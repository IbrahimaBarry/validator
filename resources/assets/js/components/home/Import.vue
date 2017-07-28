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
    </div>
</template>

<script>
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

                filter: 'all'
            }
        },

        methods: {
            addImport(id) {
              axios.get('/receptions/import/'+id)
                  .then(response => this.scans = response.data);
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
            axios.get('/receptions/getScanned').then(response => this.scans = response.data);
        }
    }
</script>

<style scoped>

</style>
