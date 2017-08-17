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
                  <option value="Magasine">Magasine</option>
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
    <div v-else>  
      <table class="table">
          <thead>
            <tr>
              <th><abbr title="type">Type du document</abbr></th>
              <th><abbr title="nom">Nom du document</abbr></th>
              <th><abbr title="sourceDate">Date de publication</abbr></th>
              <th><abbr title="nbrPage">Nombre de page</abbr></th>
              <th><abbr title="date">Date du scanne</abbr></th>
              <th><abbr title="userName">Agent scanne</abbr></th>
              <th><abbr title="nbrPage"></abbr></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="scan in filteredDocuments">
              <td>{{ scan.document.type }}</td>
              <td>{{ scan.document.name }}</td>
              <td>{{ scan.sourceDate }}</td>
              <td>{{ scan.nbrPage }}</td>
              <td>{{ scan.date_scan }}</td>
              <td>{{ scan.user_scan }}</td>
              <td v-if="scan.imported == false"><a class="button is-small is-outlined is-info" @click.prevent="addImport(scan.id)">Valider l'import</a></td>
              <td v-else>
                <span class="icon">
                  <i class="fa fa-check success"></i>
                </span>
              </td>
            </tr>
          </tbody>
        </table>

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
    </div>
</template>

<script>
import Loader from '../Loader';

    export default {
        beforeRouteEnter (to, from, next) {
          axios.get('/user').then(function(response) {
            if (response.data.import)
              next();
            else
              next({path: from.path});
          })
        },

        data() {
            return {
                scans: [],
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
            addImport(id) {
              this.loading = true;
              var self = this;
              axios.get('/receptions/import/'+id).then(function (response) {
                self.scans = response.data.data;
                self.pagination.current_page = response.data.current_page;
                self.pagination.last_page = response.data.last_page;
                self.pagination.next_page_url = response.data.next_page_url;
                self.pagination.prev_page_url = response.data.prev_page_url;
                self.loading = false;
              });
            },

            reload() {
              this.loading = true;
              this.sorted = false;
              this.sorts.search = ''; this.sorts.type = 'Type'; this.sorts.lang = 'Langue'; this.sorts.version = 'Version'; this.sorts.date = '';
              var self = this;
              axios.get('/receptions/getScanned').then(function(response) {
                self.scans = response.data.data;
                self.pagination.current_page = response.data.current_page;
                self.pagination.last_page = response.data.last_page;
                self.pagination.next_page_url = response.data.next_page_url;
                self.pagination.prev_page_url = response.data.prev_page_url;
                self.loading = false;
              });
            },

            sort() {
              this.loading = true;
              this.sorted = true;
              var self = this;
              axios.post('/sort/import', this.sorts).then(function (response) {
                self.scans = response.data.data;
                self.pagination.current_page = response.data.current_page;
                self.pagination.last_page = response.data.last_page;
                self.pagination.next_page_url = response.data.next_page_url;
                self.pagination.prev_page_url = response.data.prev_page_url;
                self.loading = false;
              });
            },

            fetch(page) {
              if (this.sorted) {
                this.loading = true;
                var self = this;
                axios.post(page, this.sorts).then(function (response) {
                  self.scans = response.data.data;
                  self.pagination.current_page = response.data.current_page;
                  self.pagination.last_page = response.data.last_page;
                  self.pagination.next_page_url = response.data.next_page_url;
                  self.pagination.prev_page_url = response.data.prev_page_url;
                  self.loading = false;
                });
              }
              else {
                this.loading = true;
                var self = this;
                axios.get(page).then(function (response) {
                  self.scans = response.data.data;
                  self.pagination.current_page = response.data.current_page;
                  self.pagination.last_page = response.data.last_page;
                  self.pagination.next_page_url = response.data.next_page_url;
                  self.pagination.prev_page_url = response.data.prev_page_url;
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
                    return this.scans.filter(scan => scan.document.frequence == 'Quotidien');
                else if (this.filter == 'Hebdomadaire')
                    return this.scans.filter(scan => scan.document.frequence == 'Hebdomadaire');
                else
                    return this.scans.filter(scan => scan.document.frequence == 'Mensuel');
            }
        },

        mounted() {
            this.loading = true;
            var self = this;
            axios.get('/receptions/getOcr').then(function (response) {
              self.scans = response.data.data;
              self.pagination.current_page = response.data.current_page;
              self.pagination.last_page = response.data.last_page;
              self.pagination.next_page_url = response.data.next_page_url;
              self.pagination.prev_page_url = response.data.prev_page_url;
              self.loading = false;
            });
        },

        components: {
          Loader
        }
    }
</script>

<style scoped>

</style>
