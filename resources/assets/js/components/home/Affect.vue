<template>
    <div>
      <nav class="level">
      <!-- Left side -->
      <div class="level-left">
        <div class="level-item">
          <div class="field has-addons">
            <p class="control">
              <input class="input" type="text" placeholder="Rechercher..." v-model="sorts.search" @keyup.enter="sort">
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
      
      <table class="table is-striped">
        <thead>
          <tr>
            <th><abbr title="type">Type du document</abbr></th>
            <th><abbr title="nom">Nom du document</abbr></th>
            <th><abbr title="sourceDate">Date de publication</abbr></th>
            <th><abbr title="nbrPage">Nombre de page</abbr></th>
            <th><abbr title="date">Date de l'import</abbr></th>
            <th><abbr title="userName">Nom de l'agent</abbr></th>
            <th><abbr title="nbrPage">Charger du clipping</abbr></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="imported in filteredDocuments" @mouseover="hoverId = imported.id">
            <td>{{ imported.document.type }}</td>
            <td>{{ imported.document.name }}</td>
            <td>{{ imported.sourceDate }}</td>
            <td>{{ imported.nbrPage }}</td>
            <td>{{ imported.date_import }}</td>
            <td>{{ imported.user_import }}</td>
            <td v-if="imported.user_clipping == null"><a class="button is-small is-outlined is-info" @click.prevent="showModal = true">Affecter à un agent de clipping</a></td>
            <td v-else>{{imported.user_clipping}}</td>
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

      <!-- MODAL -->
      <div class="modal is-active" v-if="showModal" @blur.prevent="showModal = false">
        <div class="modal-background"></div>
        <div class="modal-content box">
          <table class="table">
            <thead>
              <tr>
                <th><abbr title="type">Choisir un agent</abbr></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="agent in agents" @mouseover="hovered = agent.id" @mouseout="hovered = 0" :class="{'is-selected': hovered === agent.id}" @click.prevent="addAgent(hoverId, agent.id)">
                <td>{{ agent.name }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <button class="modal-close is-large" @click.pervent="showModal = false"></button>
      </div>
    </div>
</template>

<script>
    export default {
        beforeRouteEnter (to, from, next) {
          axios.get('/user').then(function(response) {
            if (response.data.affect)
              next();
            else
              next({path: from.path});
          })
        },

        data() {
            return {
                data: [],
                agents: [],
                pagination: {
                  current_page: '',
                  last_page: '',
                  next_page_url: '',
                  prev_page_url: '',
                },
                sorted: false,

                filter: 'all',
                showModal: false,
                hoverId: 0,
                hovered: 0,
                sorts: {
                  search: '',
                  type: 'Type',
                  lang: 'Langue',
                  version: 'Version',
                  date: ''
                }
            }
        },

        methods: {
            addAgent(receptionId,agentId) {
              var self = this;
              axios.get('/receptions/clipping/'+receptionId+'/'+agentId).then(function (response) {
                self.data = response.data.imports.data;
                self.agents = response.data.agents;
                self.pagination.current_page = response.data.imports.current_page;
                self.pagination.last_page = response.data.imports.last_page;
                self.pagination.next_page_url = response.data.imports.next_page_url;
                self.pagination.prev_page_url = response.data.imports.prev_page_url;
              });
              this.showModal = false;
            },

            reload() {
              this.sorted = false;
              this.sorts.search = ''; this.sorts.type = 'Type'; this.sorts.lang = 'Langue'; this.sorts.version = 'Version'; this.sorts.date = '';
              var self = this;
              axios.get('/receptions/getImported').then(function(response) {
                self.data = response.data.imports.data;
                self.agents = response.data.agents;
                self.pagination.current_page = response.data.imports.current_page;
                self.pagination.last_page = response.data.imports.last_page;
                self.pagination.next_page_url = response.data.imports.next_page_url;
                self.pagination.prev_page_url = response.data.imports.prev_page_url;
              });
            },

            sort() {
              this.sorted = true;
              var self = this;
              axios.post('/sort/affect', this.sorts).then(function (response) {
                self.data = response.data.imports.data;
                self.agents = response.data.agents;
                self.pagination.current_page = response.data.imports.current_page;
                self.pagination.last_page = response.data.imports.last_page;
                self.pagination.next_page_url = response.data.imports.next_page_url;
                self.pagination.prev_page_url = response.data.imports.prev_page_url;
              });
            },

            fetch(page) {
              if (this.sorted) {
                var self = this;
                axios.post(page, this.sorts).then(function (response) {
                  self.data = response.data.imports.data;
                  self.agents = response.data.agents;
                  self.pagination.current_page = response.data.imports.current_page;
                  self.pagination.last_page = response.data.imports.last_page;
                  self.pagination.next_page_url = response.data.imports.next_page_url;
                  self.pagination.prev_page_url = response.data.imports.prev_page_url;
                });
              }
              else {
                var self = this;
                axios.get(page).then(function (response) {
                  self.data = response.data.imports.data;
                  self.agents = response.data.agents;
                  self.pagination.current_page = response.data.imports.current_page;
                  self.pagination.last_page = response.data.imports.last_page;
                  self.pagination.next_page_url = response.data.imports.next_page_url;
                  self.pagination.prev_page_url = response.data.imports.prev_page_url;
                });
              }
            }
        },

        computed: {
            filteredDocuments() {
                if (this.filter == 'all')
                    return this.data;
                else if (this.filter == 'Quotidien')
                    return this.data.filter(doc => doc.document.frequence == 'Quotidien');
                else if (this.filter == 'Hebdomadaire')
                    return this.data.filter(doc => doc.document.frequence == 'Hebdomadaire');
                else
                    return this.data.filter(doc => doc.document.frequence == 'Mensuel');
            }
        },

        mounted() {
            var self = this;
            axios.get('/receptions/getImported').then(function (response) {
              self.data = response.data.imports.data;
              self.agents = response.data.agents;
              self.pagination.current_page = response.data.imports.current_page;
              self.pagination.last_page = response.data.imports.last_page;
              self.pagination.next_page_url = response.data.imports.next_page_url;
              self.pagination.prev_page_url = response.data.imports.prev_page_url;
            });
        }
    }
</script>

<style scoped>
  .is-selected {
    cursor: pointer;
  }
</style>
