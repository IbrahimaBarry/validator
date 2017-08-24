<template>
  <div>
    <nav class="level">
      <!-- Left side -->
      <div class="level-left">
        <div class="level-item">
          <div class="field has-addons">
            <p class="control">
              <input class="input" type="text" placeholder="Recherche..." v-model="sorts.search" @keyup="sort">
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
        <p class="level-item verticalLine">
          <a class="button" @click.prevent="showRecepDoc = true">Reception</a>
        </p>
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
            <th>Nombre de page</th>
            <th>Date de réception</th>
            <th>Agent reception</th>
            <th>Cause du retard</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="document in filteredDocuments" @mouseover.prevent="hoverId = document.id">
            <td>{{ document.document.type }}</td>
            <td>{{ document.document.name }}</td>
            <td>{{ document.sourceDate }}</td>
            <td :class="{edit: document === editing}">
              <div v-if="document != editing" @dblclick.prevent="editDocument(document)">{{ document.nbrPage }}</div>
              <input v-else type="numeric" class="input" @keyup.enter="doneEdit(document.nbrPage)" v-model="document.nbrPage" 
              v-focus="document === editing" @keyup.esc="cancelEdit" @blur="cancelEdit">
            </td>
            <td>{{ document.created_at }}</td>
            <td>{{ document.user.name }}</td>
            <td>{{ document.message }}</td>
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

    <RecepDoc v-if="showRecepDoc" @hideRecepDoc="showRecepDoc = false" :id="hoverId" @documentRecepted="updateDocuments"></RecepDoc>
  </div>
</template>

<script>
import RecepDoc from './RecepDoc';
import Loader from '../Loader';

    export default {
        beforeRouteEnter (to, from, next) {
          axios.get('/user').then(function(response) {
            if (response.data.reception)
              next();
            else
              next({path: from.path});
          })
        },

        data() {
            return {
                documents: [],
                pagination: {
                  current_page: '',
                  last_page: '',
                  next_page_url: '',
                  prev_page_url: '',
                },
                sorted: false,
                filter: 'all',
                hoverId: 0,
                showRecepDoc: false,
                sorts: {
                  search: '',
                  type: 'Type',
                  lang: 'Langue',
                  version: 'Version',
                  date: ''
                },
                loading: false,
                editing: null,
                oldEditing: null
            }
        },

        methods: {
            paginate(pages) {
              this.pagination.current_page = pages.current_page;
              this.pagination.last_page = pages.last_page;
              this.pagination.next_page_url = pages.next_page_url;
              this.pagination.prev_page_url = pages.prev_page_url;
            },

            updateDocuments() {
              this.loading = true;
              var self = this;
              axios.get('/receptions/index').then(function(response) {
                self.documents = response.data.data;
                self.paginate(response.data);
                self.showRecepDoc = false;
                self.loading = false;
              });
            },

            reload() {
              this.loading = true;
              this.sorted = false;
              this.sorts.search = ''; this.sorts.type = 'Type'; this.sorts.lang = 'Langue'; this.sorts.version = 'Version'; this.sorts.date = '';
              var self = this;
              axios.get('/receptions/index').then(function(response) {
                self.documents = response.data.data;
                self.paginate(response.data);
                self.loading = false;
              });
            },

            sort() {
              this.loading = true;
              this.sorted = true;
              var self = this;
              axios.post('/sort/reception', this.sorts).then(function (response) {
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
                  self.documents = response.data.data;
                  self.paginate(response.data);
                  self.loading = false;
                });
              }
            },

            editDocument(val) {
              this.editing = val;
              this.oldEditing = val.nbrPage;
            },

            doneEdit(nbrPage) {
              axios.get('/receptions/update/'+this.editing.id+'/'+nbrPage).then(this.editing = null);
            },

            cancelEdit() {
              this.editing.nbrPage = this.oldEditing;
              this.editing = null
            }
        },

        computed: {
            filteredDocuments() {
                if (this.filter == 'all')
                    return this.documents;
                else if (this.filter == 'Quotidien')
                    return this.documents.filter(document => document.document.frequence == 'Quotidien');
                else if (this.filter == 'Hebdomadaire')
                    return this.documents.filter(document => document.document.frequence == 'Hebdomadaire');
                else
                    return this.documents.filter(document => document.document.frequence == 'Mensuel');
            }
        },

        directives: {
          focus(el, value) {
            Vue.nextTick(_ => {
              el.focus();
            })
          }
        },

        mounted() {
            this.loading = true;
            var self = this;
            axios.get('/receptions/index').then(function(response) {
              self.documents = response.data.data;
              self.paginate(response.data);
              self.loading = false;
            });
        },

        components: {
            RecepDoc,
            Loader
        }
    }
</script>

<style scoped>
  td > input{
    display: none
  }
  .edit > input {
    display: initial;
  }

  .verticalLine {
    border-left: thick solid hsl(0, 0%, 21%);
  }
</style>
