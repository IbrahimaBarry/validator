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
    <div v-else>
      <table class="table">
        <thead>
          <tr>
            <th>Type du document</th>
            <th>Nom du document</th>
            <th>Date de publication</th>
            <th>Nbr. de page</th>
            <th>Date clipping</th>
            <th>Agent clipping</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="doc in filteredDocuments">
            <td>{{ doc.clipping.import.scan.reception.document.type }}</td>
            <td>{{ doc.clipping.import.scan.reception.document.name }}</td>
            <td>{{ doc.clipping.import.scan.reception.sourceDate }}</td>
            <td>{{ doc.clipping.import.scan.reception.nbrPage }}</td>
            <td>{{ doc.clipping.date_clipping }}</td>
            <td>{{ doc.clipping.user.name }}</td>
            <div v-if="doc.exported">
              <td v-if="doc.confirmed">
                <span class="icon">
                  <i class="fa fa-check success"></i>
                </span>
              </td>
              <div v-else>
                <td v-if="role == 'agent'">En attente...</td>
                <td v-else>
                  <a class="button is-small is-primary is-outlined" @click.prevent="confirm(doc)">Confirmer</a>
                </td>
              </div>
            </div>
            <td v-else>
              <a class="button is-small is-outlined is-info" @click.prevent="addExport(doc)">Valider l'export</a>
              <!-- <a class="delete is-medium danger" @click.prevent="showDelete = true"></a> -->
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

      <!-- DELETE -->
      <!-- <div class="modal is-active" v-if="showDelete">
        <div class="modal-background"></div>
        <div class="modal-content box has-text-centered">
          <span class="icon is-large">
            <i class="fa fa-warning"></i>
          </span>
          <h4 class="title is-4">Êtes vous sûr de vouloir supprimer cet objet?</h4>
          <a class="button is-small is-primary" @click.prevent="deleteClipped(detail.id)">OUI</a>
          <a class="button is-small" @click.pervent="showDelete = false">NON</a>
        </div>
      </div> -->
    </div>
</template>

<script>
import Loader from '../Loader';

    export default {
        beforeRouteEnter (to, from, next) {
          axios.get('/user').then(function(response) {
            if (response.data.export)
              next();
            else
              next({path: from.path});
          })
        },

        data() {
            return {
                role: '',
                documents: [],
                pagination: {
                  current_page: '',
                  last_page: '',
                  next_page_url: '',
                  prev_page_url: '',
                },
                sorted: false,

                filter: 'all',
                showDetail: false,
                showDelete: false,
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
            
            addExport(doc) {
              this.loading = true;
              var self = this;
              axios.get('/export/'+doc.id).then(function (response) {
                doc.exported = true;
                self.loading = false;
              });
            },

            confirm(doc) {
              this.loading = true;
              var self = this;
              axios.get('/export/confirm/'+doc.id).then(function (response) {
                doc.confirmed = true;
                self.loading = false;
              });
            },

            // deleteClipped(id) {
            //   this.loading = true;
            //   var self = this;
            //   axios.get('/receptions/deleteClipping/'+id).then(function (response) {
            //     self.documents = response.data.data;
            //     self.paginate(response.data);
            //     self.loading = false;
            //   });
            //   this.showDelete = false;
            // },

            reload() {
              this.loading = true;
              this.sorted = false;
              this.sorts.search = ''; this.sorts.type = 'Type'; this.sorts.lang = 'Langue'; this.sorts.version = 'Version'; this.sorts.date = '';
              var self = this;
              axios.get('/export/index').then(function(response) {
                self.documents = response.data.exports.data;
                self.paginate(response.data.exports);
                self.loading = false;
              });
            },

            sort() {
              this.loading = true;
              this.sorted = true;
              var self = this;
              axios.post('/sort/export', this.sorts).then(function (response) {
                self.documents = response.data.data;
                self.paginate(response.data);
                self.loading = false;
              });
            },

            fetch(page) {
              if (this.sorted) {
                this.loading = true;
                var self = this;
                axios.post(page, this.sorts).then(function (response) {
                  self.documents = response.data.data;
                  self.paginate(response.data);
                  self.loading = false;
                });
              }
              else {
                this.loading = true;
                var self = this;
                axios.get(page).then(function (response) {
                  self.documents = response.data.exports.data;
                  self.paginate(response.data.exports);
                  self.loading = false;
                });
              }
            }
        },

        computed: {
            filteredDocuments() {
                if (this.filter == 'all')
                    return this.documents;
                else if (this.filter == 'Quotidien')
                    return this.documents.filter(doc => doc.document.frequence == 'Quotidien');
                else if (this.filter == 'Hebdomadaire')
                    return this.documents.filter(doc => doc.document.frequence == 'Hebdomadaire');
                else
                    return this.documents.filter(doc => doc.document.frequence == 'Mensuel');
            }
        },

        mounted() {
            this.loading = true;
            var self = this;
            axios.get('/export/index').then(function (response) {
              self.role = response.data.role;
              self.documents = response.data.exports.data;
              self.paginate(response.data.exports);
              self.loading = false;
            });
        },

        components: {
          Loader
        }
    }
</script>

<style scoped>
  .danger {
    background: hsl(348, 100%, 61%);
  }

  .fa-warning {
    padding: 14px;
    color: hsl(48, 100%, 67%);
    margin-bottom: 20px;
  }
</style>
