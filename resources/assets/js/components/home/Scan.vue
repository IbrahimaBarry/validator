<template>
    <div>
      <nav class="level">
        <!-- Left side -->
        <div class="level-left">
          <div class="level-item">
            <div class="field has-addons">
              <p class="control">
                <input class="input" type="text" placeholder="Rechercher..." v-model="sorts.search" @keyup="sort">
              </p>
              <div class="control">
                <div class="select">
                  <select v-model="sorts.type" @change.prevent="sort">
                    <option>Type</option>
                    <option value="Magazine">Magazine</option>
                    <option value="Journal">Journal</option>
                  </select>
                </div>
              </div>
              <div class="control">
                <div class="select">
                  <select v-model="sorts.lang" @change.prevent="sort">
                    <option>Langue</option>
                    <option value="Anglais">Anglais</option>
                    <option value="Arabe">Arabe</option>
                    <option value="Français">Français</option>
                    <option value="Tamazight">Tamazight</option>
                  </select>
                </div>
              </div>
              <div class="control">
                <div class="select">
                  <select v-model="sorts.version" @change.prevent="sort">
                    <option>Version</option>
                    <option value="Papier">Papier</option>
                    <option value="Electronique">Electronique</option>
                  </select>
                </div>
              </div>
              <p class="control">
                <input class="input" type="date" v-model="sorts.date" @change.prevent="sort">
              </p>
              <p class="control"><button class="button is-info is-inverted" @click.prevent="reload"><i class="fa fa-refresh" aria-hidden="true"></i></button></p>
            </div>
          </div>
        </div>

        <!-- Right side -->
        <div class="level-right">
          <p class="level-item"><a :class="{'is-active': filter == 'all'}" @click.prevent="filter = 'all'">Tous</a></p>
          <p class="level-item"><a :class="{'is-active': filter == 'Quotidien'}" @click.prevent="filter = 'Quotidien'">Quotidiens</a></p>
          <p class="level-item"><a :class="{'is-active': filter=='Hebdomadaire'}" @click.prevent="filter='Hebdomadaire'">Hebdomadaires</a></p>
          <p class="level-item"><a :class="{'is-active': filter == 'Mensuel'}" @click.prevent="filter = 'Mensuel'">Mensuels</a></p>
        </div>
      </nav>
      
      <Loader v-if="loading"></Loader>
      <table :class="{table: true, loading: loading}">
          <thead>
            <tr>
              <th>Type du document</th>
              <th>Nom du document</th>
              <th>Date de publication</th>
              <th>Nombre de page</th>
              <th>Date de réception</th>
              <th>Agent reception</th>
              <th>Observation</th>
              <th>Etat</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="scan in filteredDocuments">
              <td>{{ scan.reception.document.type }}</td>
              <td>{{ scan.reception.document.name }}</td>
              <td>{{ scan.reception.sourceDate }}</td>
              <td>{{ scan.reception.nbrPage }}</td>
              <td>{{ scan.reception.created_at }}</td>
              <td>{{ scan.reception.user.name }}</td>
              <td>{{ scan.message }}</td>
              <div v-if="scan.scanned">
                <td v-if="scan.confirmed">
                  <span class="icon">
                    <i class="fa fa-check success"></i>
                  </span>
                </td>
                <div v-else>
                  <td v-if="role == 'agent'">En attente...</td>
                  <td v-else>
                    <a class="button is-small is-primary is-outlined" @click.prevent="doneScan(scan)">Confirmer</a>
                  </td>
                </div>
              </div>
              <td v-else>
                <a class="button is-small is-info is-outlined" @click.prevent="startScan(scan)">Démarrer le scanne</a>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Validation SCAN -->
        <div class="modal is-active" v-if="showModal">
          <div class="modal-background"></div>
          <div class="modal-card">
            <header class="modal-card-head">
              <p class="modal-card-title">Démarrer scan</p>
              <button class="delete" aria-label="close" @click.prevent="showModal = false"></button>
            </header>
            <section class="modal-card-body">
              <div class="field">
                <label class="label">Observation</label>
                <div class="control">
                  <div class="select">
                    <select v-model="scan.message">
                      <option disabled>-- Choisir un message --</option>
                      <option>Scan avec reserve</option>
                      <option>Page manquante</option>
                      <option>Mal imprimé</option>
                    </select>
                  </div>
                </div>
              </div>
            </section>
            <footer class="modal-card-foot">
              <button class="button is-success" @click.prevent="addScan">Valider</button>
              <button class="button" @click.prevent="showModal = false">Annuler</button>
            </footer>
          </div>
        </div>

        <!-- PAGINATION -->
        <nav class="pagination" v-if="pagination.last_page > 1">
          <a class="pagination-previous" title="This is the first page" @click.prevent="fetch(pagination.prev_page_url)" 
          :disabled="!pagination.prev_page_url">Precedent</a>
          <a class="pagination-next" @click.prevent="fetch(pagination.next_page_url)" 
          :disabled="!pagination.next_page_url">Page suivant</a>
          <ul class="pagination-list">
            <li>
              <span class="pagination-ellipsis">Page</span>
              <a class="pagination-link is-current">{{ pagination.current_page }}</a>
            </li>
            <li><span class="pagination-ellipsis">sur</span></li>
            <li><a class="pagination-link">{{ pagination.last_page }}</a></li>
          </ul>
        </nav>
    </div>
</template>

<script>
import Loader from '../Loader';

    export default {
        beforeRouteEnter (to, from, next) {
          axios.get('/user').then(function(response) {
            if (response.data.scan)
              next();
            else
              next({path: from.path});
          })
        },

        data() {
            return {
                showModal: false,
                role: '',
                scans: [],
                scan: null,
                pagination: {
                  current_page: '',
                  last_page: '',
                  next_page_url: '',
                  prev_page_url: '',
                },
                sorted: false,

                filter: 'all',
                sorts: {
                  search: '',
                  type: 'Type',
                  lang: 'Langue',
                  version: 'Version',
                  date: ''
                },

                loading: false
            }
        },

        methods: {
            paginate(pages) {
              this.pagination.current_page = pages.current_page;
              this.pagination.last_page = pages.last_page;
              this.pagination.next_page_url = pages.next_page_url;
              this.pagination.prev_page_url = pages.prev_page_url;
            },

            startScan(scan) {
              this.scan = scan;
              this.showModal = true;
            },

            addScan() {
              this.loading = true;
              var self = this;
              axios.get('/scan/scanning/'+this.scan.id+'/'+this.scan.message).then(function (response) {
                self.scan.scanned = true;
                self.showModal = false;
                self.loading = false;
              });
            },

            doneScan(scan) {
              this.loading = true;
              var self = this;
              axios.get('/scan/confirm/'+scan.id).then(function (response) {
                scan.confirmed = true;
                self.loading = false;
              });
            },

            reload() {
              this.loading = true;
              this.sorted = false;
              this.sorts.search = ''; this.sorts.type = 'Type'; this.sorts.lang = 'Langue'; this.sorts.version = 'Version'; this.sorts.date = '';
              var self = this;
              axios.get('/scan/index').then(function (response) {
                self.role = response.data.role;
                self.scans = response.data.scans.data;
                self.paginate(response.data.scans);
                self.loading = false;
              });
            },

            sort() {
              this.loading = true;
              this.sorted = true;
              var self = this;
              axios.post('/sort/scan', this.sorts).then(function (response) {
                self.scans = response.data.data;
                self.paginate(response.data);
                self.loading = false;
              });
            },

            fetch(page) {
              if (this.sorted) {
                this.loading = true;
                var self = this;
                axios.post(page, this.sorts).then(function (response) {
                  self.scans = response.data.data;
                  self.paginate(response.data);
                  self.loading = false;
                });
              }
              else {
                this.loading = true;
                var self = this;
                axios.get(page).then(function (response) {
                  self.scans = response.data.scans.data;
                  self.paginate(response.data.scans);
                  self.loading = false;
                });
              }
            }
        },

        computed: {
            filteredDocuments() {
                if (this.filter == 'all')
                    return this.scans;
                else if (this.filter == 'Quotidien')
                    return this.scans.filter(scan => scan.reception.document.frequence == 'Quotidien');
                else if (this.filter == 'Hebdomadaire')
                    return this.scans.filter(scan => scan.reception.document.frequence == 'Hebdomadaire');
                else
                    return this.scans.filter(scan => scan.reception.document.frequence == 'Mensuel');
            }
        },

        mounted() {
            this.loading = true;
            var self = this;
            axios.get('/scan/index').then(function (response) {
              self.role = response.data.role;
              self.scans = response.data.scans.data;
              self.paginate(response.data.scans);
              self.loading = false;
            });
        },

        components: {
          Loader
        }
    }
</script>

<style scoped>
  .verticalLine {
    border-left: thick solid hsl(0, 0%, 21%);
  }
</style>
