<template>
    <div>
      <nav class="level">
        <!-- Left side -->
        <div class="level-left">
          <div class="level-item">
            <p class="subtitle is-5">
              <strong>{{filteredDocuments.length}}</strong> Documents
            </p>
          </div>
          <!-- <div class="level-item">
            <div class="field has-addons">
              <p class="control">
                <input class="input" type="text" placeholder="Rechercher...">
              </p>
              <p class="control">
                <button class="button">
                  Recherche
                </button>
              </p>
            </div>
          </div> -->
        </div>

        <!-- Right side -->
        <div class="level-right">
          <p class="level-item"><a :class="{'is-active': filter == 'all'}" @click.prevent="filter = 'all'">Tous</a></p>
          <p class="level-item"><a :class="{'is-active': filter == 'quotidien'}" @click.prevent="filter = 'quotidien'">Quotidiens</a></p>
          <p class="level-item"><a :class="{'is-active': filter=='hebdomadaire'}" @click.prevent="filter='hebdomadaire'">Hebdomadaires</a></p>
          <p class="level-item"><a :class="{'is-active': filter == 'mensuel'}" @click.prevent="filter = 'mensuel'">Mensuels</a></p>
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

                hovered: 0
            }
        },

        methods: {
            addAgent(receptionId,agentId) {
              axios.get('/receptions/clipping/'+receptionId+'/'+agentId).then(response => this.data = response.data);
              this.showModal = false;
            }
        },

        computed: {
            filteredDocuments() {
                if (this.filter == 'all')
                    return this.data.imports;
                else if (this.filter == 'quotidien')
                    return this.data.imports.filter(doc => doc.document.frequence == 'quotidien');
                else if (this.filter == 'hebdomadaire')
                    return this.data.imports.filter(doc => doc.document.frequence == 'hebdomadaire');
                else
                    return this.data.imports.filter(doc => doc.document.frequence == 'mensuel');
            }
        },

        mounted() {
            axios.get('/receptions/import').then(response => this.data = response.data);
        }
    }
</script>

<style scoped>
  .is-selected {
    cursor: pointer;
  }
</style>
