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
        <div class="level-item">
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
          <tr v-for="document in filteredDocuments" @mouseover.prevent="hoverId = document.id">
            <td>{{ document.document.type }}</td>
              <td>{{ document.document.name }}</td>
              <td>{{ document.sourceDate }}</td>
              <td>{{ document.nbrPage }}</td>
              <td>{{ document.created_at }}</td>
              <td>{{ document.user.name }}</td>
              <td>{{ document.message }}</td>
            <td>
              <a class="button is-info is-small is-outlined" @click.prevent="showRecepDoc = true">Valider la reception</a>
            </td>
          </tr>
        </tbody>
      </table>

    <RecepDoc v-if="showRecepDoc" @hideRecepDoc="showRecepDoc = false" :id="hoverId" @documentRecepted="updateDocuments($event)"></RecepDoc>
  </div>
</template>

<script>
import RecepDoc from './RecepDoc';

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
                filter: 'all',
                hoverId: 0,
                showRecepDoc: false
            }
        },

        methods: {
            updateDocuments(event) {
              this.showRecepDoc = false;
              this.documents = event;
            }
        },

        computed: {
            filteredDocuments() {
                if (this.filter == 'all')
                    return this.documents;
                else if (this.filter == 'Quotidien')
                    return this.documents.filter(document => document.frequence == 'Quotidien');
                else if (this.filter == 'Hebdomadaire')
                    return this.documents.filter(document => document.frequence == 'Hebdomadaire');
                else
                    return this.documents.filter(document => document.frequence == 'Mensuel');
            }
        },

        mounted() {
            axios.get('/receptions/index').then(response => this.documents = response.data);
        },

        components: {
            RecepDoc
        }
    }
</script>

<style scoped>

</style>
