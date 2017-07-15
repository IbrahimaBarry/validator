<template>
    <div>
      <div class="tabs is-centered is-medium">
        <ul>
          <li :class="{'is-active': filter == 'all'}"><a @click.prevent="filter = 'all'">Tous</a></li>
          <li :class="{'is-active': filter == 'quotidien'}"><a @click.prevent="filter = 'quotidien'">Quotidiens</a></li>
          <li :class="{'is-active': filter=='hebdomadaire'}"><a @click.prevent="filter='hebdomadaire'">Hebdomadaires</a></li>
          <li :class="{'is-active': filter == 'mensuel'}"><a @click.prevent="filter = 'mensuel'">Mensuels</a></li>
        </ul>
      </div>

      <div class="columns">
        <p class="field  column is-5">
          <input class="input" type="text" placeholder="Text input">
        </p>
        <!-- <div class="column is-offset-5">
          <a class="button is-info" @click.prevent="showModal = true">Ajouter un document</a>
        </div> -->
      </div>
      
      <table class="table">
          <thead>
            <tr>
              <th><abbr title="nom">Type du document</abbr></th>
              <th><abbr title="nom">Nom du document</abbr></th>
              <th><abbr title="userName">Nom de l'agent</abbr></th>
              <th><abbr title="sourceDate">Date de publication</abbr></th>
              <th><abbr title="nbrPage">Nombre de page</abbr></th>
              <th><abbr title="nbrPage">Date de scanne</abbr></th>
              <th><abbr title="nbrPage"></abbr></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="reception in filteredReceptions">
              <td>{{ reception.document.type }}</td>
              <td>{{ reception.document.name }}</td>
              <td>{{ reception.user_scan }}</td>
              <td>{{ reception.sourceDate }}</td>
              <td>{{ reception.nbrPage }}</td>
              <td>{{ reception.date_scan }}</td>
              <td v-if="reception.scanned == false"><a class="button is-small is-info" @click.prevent="addAgent(reception.id)">Affecté à un clippeur</a></td>
              <td v-else>Affecté à un clippeur</td>
            </tr>
          </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                showModal: false,

                receptions: [],

                filter: 'all'
            }
        },

        methods: {
            addScan(id) {
              axios.get('/receptions/scan/'+id)
                  .then(response => this.receptions = response.data);
            }
        },

        computed: {
            filteredReceptions() {
                if (this.filter == 'all')
                    return this.receptions;
                else if (this.filter == 'quotidien')
                    return this.receptions.filter(reception => reception.document.frequence == 'quotidien');
                else if (this.filter == 'hebdomadaire')
                    return this.receptions.filter(reception => reception.document.frequence == 'hebdomadaire');
                else
                    return this.receptions.filter(reception => reception.document.frequence == 'mensuel');
            }
        },

        mounted() {
            axios.get('/receptions/scan').then(response => this.receptions = response.data);
        }
    }
</script>

<style scoped>

</style>
