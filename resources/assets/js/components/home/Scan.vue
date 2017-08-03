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
              <th><abbr title="sourceDate">Date de publication</abbr></th>
              <th><abbr title="nbrPage">Nombre de page</abbr></th>
              <th><abbr title="date">Date de réception</abbr></th>
              <th><abbr title="userName">Agent reception</abbr></th>
              <th><abbr title="userName">Cause du retard</abbr></th>
              <th><abbr title="nbrPage"></abbr></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="reception in sortedDocuments">
              <td>{{ reception.document.type }}</td>
              <td>{{ reception.document.name }}</td>
              <td>{{ reception.sourceDate }}</td>
              <td>{{ reception.nbrPage }}</td>
              <td>{{ reception.created_at }}</td>
              <td>{{ reception.user.name }}</td>
              <td>{{ reception.message }}</td>
              <td v-if="reception.scanned == false"><a class="button is-small is-info is-outlined" @click.prevent="addScan(reception.id)">Valider le scanne</a></td>
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
</template>

<script>
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
                receptions: [],
                pagination: {
                  current_page: '',
                  last_page: '',
                  next_page_url: '',
                  prev_page_url: '',
                },

                filter: 'all',
                search: '',
                type: 'Type',
                lang: 'Langue',
                version: 'Version'
            }
        },

        methods: {
            addScan(id) {
              var self = this;
              axios.get('/receptions/scan/'+id).then(function (response) {
                self.receptions = response.data.data;
                self.pagination.current_page = response.data.current_page;
                self.pagination.last_page = response.data.last_page;
                self.pagination.next_page_url = response.data.next_page_url;
                self.pagination.prev_page_url = response.data.prev_page_url;
              });
            },

            reload() {
              this.search = ''; this.type = 'Type'; this.lang = 'Langue'; this.version = 'Version';
            },

            fetch(page) {
              var self = this;
              axios.get(page).then(function (response) {
                self.receptions = response.data.data;
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
                    return this.receptions;
                else if (this.filter == 'Quotidien')
                    return this.receptions.filter(reception => reception.document.frequence == 'Quotidien');
                else if (this.filter == 'Hebdomadaire')
                    return this.receptions.filter(reception => reception.document.frequence == 'Hebdomadaire');
                else
                    return this.receptions.filter(reception => reception.document.frequence == 'Mensuel');
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
            axios.get('/receptions/index').then(function (response) {
              self.receptions = response.data.data;
              self.pagination.current_page = response.data.current_page;
              self.pagination.last_page = response.data.last_page;
              self.pagination.next_page_url = response.data.next_page_url;
              self.pagination.prev_page_url = response.data.prev_page_url;
            });
        }
    }
</script>

<style scoped>
  
</style>
