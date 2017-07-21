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
            <th><abbr title="date">Date de publication</abbr></th>
            <th><abbr title="nbrPage">Nbr. de page</abbr></th>
            <th><abbr title="nbrPage">Date export</abbr></th>
            <th><abbr title="userName">Nom de l'agent</abbr></th>
            <th><abbr title="userName"></abbr></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="doc in filteredDocuments">
            <td>{{ doc.document.type }}</td>
            <td>{{ doc.document.name }}</td>
            <td>{{ doc.sourceDate }}</td>
            <td>{{ doc.nbrPage }}</td>
            <td>{{ doc.date_export }}</td>
            <td>{{ doc.user_export }}</td>
            <td>
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
            if (response.data.export)
              next();
            else
              next({path: from.path});
          })
        },

        data() {
            return {
                documents: [],

                filter: 'all'
            }
        },

        computed: {
            filteredDocuments() {
                if (this.filter == 'all')
                    return this.documents;
                else if (this.filter == 'quotidien')
                    return this.documents.filter(doc => doc.document.frequence == 'quotidien');
                else if (this.filter == 'hebdomadaire')
                    return this.documents.filter(doc => doc.document.frequence == 'hebdomadaire');
                else
                    return this.documents.filter(doc => doc.document.frequence == 'mensuel');
            }
        },

        mounted() {
            axios.get('/receptions/export').then(response => this.documents = response.data);
        }
    }
</script>

<style scoped>

</style>
