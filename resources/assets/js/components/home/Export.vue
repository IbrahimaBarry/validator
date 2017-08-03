<template>
    <div>
      <nav class="level">
      <!-- Left side -->
      <div class="level-left">
        <div class="level-item">
          <p class="subtitle is-5">
            <strong>{{sortedDocuments.length}}</strong> Documents
          </p>
        </div>
        <div class="level-item">
          <div class="field has-addons">
            <p class="control">
              <input class="input" type="text" placeholder="Rechercher..." @keyup.enter="search = $event.target.value">
            </p>
            <div class="control">
              <div class="select">
                <select v-model="type">
                  <option>Type</option>
                  <option value="Magasine">Magasine</option>
                  <option value="Journal">Journal</option>
                </select>
              </div>
            </div>
            <div class="control">
              <div class="select">
                <select v-model="lang">
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
                <select v-model="version">
                  <option>Version</option>
                  <option value="Papier">Papier</option>
                  <option value="Electronique">Electronique</option>
                </select>
              </div>
            </div>
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
      
      <table class="table is-striped">
        <thead>
          <tr>
            <th><abbr title="type">Type du document</abbr></th>
            <th><abbr title="nom">Nom du document</abbr></th>
            <th><abbr title="date">Date de publication</abbr></th>
            <th><abbr title="nbrPage">Nbr. de page</abbr></th>
            <th><abbr title="nbrPage">Date clipping</abbr></th>
            <th><abbr title="userName">Agent clipping</abbr></th>
            <th><abbr title="nbrPage"></abbr></th>
            <th><abbr title="nbrPage"></abbr></th>
            <th><abbr title="nbrPage"></abbr></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="doc in sortedDocuments" @mouseover="detail = doc">
            <td>{{ doc.document.type }}</td>
            <td>{{ doc.document.name }}</td>
            <td>{{ doc.sourceDate }}</td>
            <td>{{ doc.nbrPage }}</td>
            <td>{{ doc.date_clipping }}</td>
            <td>{{ doc.user_clipping }}</td>
            <div v-if="doc.exported == false">
              <td><a class="button is-small is-outlined is-info" @click.prevent="addExport(doc.id)">Valider l'export</a></td>
              <td><a class="delete is-medium danger" @click.prevent="showDelete = true"></a></td>
            </div>
            <td v-else>
              <span class="icon">
                <i class="fa fa-check success"></i>
              </span>
            </td>
            <td><a class="button is-small is-info" @click.prevent="showDetail = true">Détails</a></td>
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
      
      <!-- DETAIL -->
      <div class="modal is-active" v-if="showDetail">
        <div class="modal-background"></div>
        <div class="modal-content box">
          <table class="table">
            <thead>
              <tr>
                <th><abbr title="type">Détails du clipping</abbr></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Type du document</td>
                <td>{{ detail.document.type }}</td>
              </tr>
              <tr>
                <td>Nom du document</td>
                <td>{{ detail.document.name }}</td>
              </tr>
              <tr>
                <td>Date de publication</td>
                <td>{{ detail.sourceDate }}</td>
              </tr>
              <tr>
                <td>Nbr. de page</td>
                <td>{{ detail.nbrPage }}</td>
              </tr>
              <tr>
                <td>Date clipping</td>
                <td>{{ detail.date_clipping }}</td>
              </tr>
              <tr>
                <td>Nom du clippeur</td>
                <td>{{ detail.user_clipping }}</td>
              </tr>
              <tr>
                <td>Nombre de d'articles total</td>
                <td>{{ detail.nbrArtTotal }}</td>
              </tr>
              <tr>
                <td>Durée totale du clipping</td>
                <td>{{ detail.time }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <button class="modal-close is-large" @click.pervent="showDetail = false"></button>
      </div>

      <!-- DELETE -->
      <div class="modal is-active" v-if="showDelete">
        <div class="modal-background"></div>
        <div class="modal-content box has-text-centered">
          <span class="icon is-large">
            <i class="fa fa-warning"></i>
          </span>
          <h4 class="title is-4">Êtes vous sûr de vouloir supprimer cet objet?</h4>
          <a class="button is-small is-primary" @click.prevent="deleteClipped(detail.id)">OUI</a>
          <a class="button is-small" @click.pervent="showDelete = false">NON</a>
        </div>
      </div>
    </div>
</template>

<script>
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
                documents: [],
                pagination: {
                  current_page: '',
                  last_page: '',
                  next_page_url: '',
                  prev_page_url: '',
                },

                filter: 'all',
                showDetail: false,
                showDelete: false,
                detail: {},
                search: '',
                type: 'Type',
                lang: 'Langue',
                version: 'Version'
            }
        },

        methods: {
            addExport(id) {
              var self = this;
              axios.get('/receptions/export/'+id).then(function (response) {
                self.documents = response.data.data;
                self.pagination.current_page = response.data.current_page;
                self.pagination.last_page = response.data.last_page;
                self.pagination.next_page_url = response.data.next_page_url;
                self.pagination.prev_page_url = response.data.prev_page_url;
              });
            },

            deleteClipped(id) {
              var self = this;
              axios.get('/receptions/deleteClipping/'+id).then(function (response) {
                self.documents = response.data.data;
                self.pagination.current_page = response.data.current_page;
                self.pagination.last_page = response.data.last_page;
                self.pagination.next_page_url = response.data.next_page_url;
                self.pagination.prev_page_url = response.data.prev_page_url;
              });
              this.showDelete = false;
            },

            reload() {
              this.search = ''; this.type = 'Type'; this.lang = 'Langue'; this.version = 'Version';
            },

            fetch(page) {
              var self = this;
              axios.get(page).then(function (response) {
                self.documents = response.data.data;
                self.pagination.current_page = response.data.current_page;
                self.pagination.last_page = response.data.last_page;
                self.pagination.next_page_url = response.data.next_page_url;
                self.pagination.prev_page_url = response.data.prev_page_url;
              });
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
            },

            sortedDocuments() {
              var temp;
                if (this.search == '')
                  temp = this.filteredDocuments;
                else
                  temp = this.filteredDocuments.filter(document => document.document.name == this.search);

                if (this.type != 'Type')
                  temp = temp.filter(document => document.document.type == this.type);
                if (this.lang != 'Langue')
                  temp = temp.filter(document => document.document.lang == this.lang);
                if (this.version != 'Version')
                  temp = temp.filter(document => document.document.version == this.version);

                return temp;
              }
        },

        mounted() {
            var self = this;
            axios.get('/receptions/getClipped').then(function (response) {
              self.documents = response.data.data;
              self.pagination.current_page = response.data.current_page;
              self.pagination.last_page = response.data.last_page;
              self.pagination.next_page_url = response.data.next_page_url;
              self.pagination.prev_page_url = response.data.prev_page_url;
            });
        }
    }
</script>

<style scoped>
  .danger {
    background: red;
  }

  .fa-warning {
    padding: 14px;
    color: hsl(48, 100%, 67%);
    margin-bottom: 20px;
  }
</style>
