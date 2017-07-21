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
              <th><abbr title="date">Date de réception</abbr></th>
              <th><abbr title="userName">Nom de l'agent</abbr></th>
              <th><abbr title="userName">Cause du retard</abbr></th>
              <th><abbr title="nbrPage"></abbr></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="reception in filteredDocuments">
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
            filteredDocuments() {
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
            axios.get('/receptions/index').then(response => this.receptions = response.data);
        }
    }
</script>

<style scoped>

</style>
