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
        <p class="level-item">
          <a class="button is-info is-outlined" @click.prevent="showRecepDoc = true">Reception</a>
          </p>
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
          <tr v-for="imported in sortedDocuments" @mouseover="hoverId = imported.id">
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
              <tr v-for="agent in data.agents" @mouseover="hovered = agent.id" @mouseout="hovered = 0" :class="{'is-selected': hovered === agent.id}" @click.prevent="addAgent(hoverId, agent.id)">
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
                filter: 'all',
                showModal: false,
                hoverId: 0,
                hovered: 0,
                search: '',
                type: 'Type',
                lang: 'Langue',
                version: 'Version'
            }
        },

        methods: {
            addAgent(receptionId,agentId) {
              axios.get('/receptions/clipping/'+receptionId+'/'+agentId).then(response => this.data = response.data);
              this.showModal = false;
            },

            reload() {
              this.search = ''; this.type = 'Type'; this.lang = 'Langue'; this.version = 'Version';
            }
        },

        computed: {
            filteredDocuments() {
                if (this.filter == 'all')
                    return this.data.imports;
                else if (this.filter == 'Quotidien')
                    return this.data.imports.filter(doc => doc.document.frequence == 'Quotidien');
                else if (this.filter == 'Hebdomadaire')
                    return this.data.imports.filter(doc => doc.document.frequence == 'Hebdomadaire');
                else
                    return this.data.imports.filter(doc => doc.document.frequence == 'Mensuel');
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
            axios.get('/receptions/getImported').then(response => this.data = response.data);
        }
    }
</script>

<style scoped>
  .is-selected {
    cursor: pointer;
  }
</style>
