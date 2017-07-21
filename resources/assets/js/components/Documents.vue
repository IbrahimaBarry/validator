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
        <p class="level-item"><a class="button is-primary" @click.prevent="showAddDoc = true">Ajouter un document</a></p>
      </div>
    </nav>
    
    <table class="table is-striped">
        <thead>
          <tr>
            <th><abbr title="nom">Nom</abbr></th>
            <th><abbr title="source">Source</abbr></th>
            <th><abbr title="source name">Source name</abbr></th>
            <th><abbr title="type">Type</abbr></th>
            <th><abbr title="version">Version</abbr></th>
            <th><abbr title="frequence">Fréquence</abbr></th>
            <th><abbr title="langue">Langue</abbr></th>
            <th><abbr title="action">Date dernière reception</abbr></th>
            <th><abbr title="action"></abbr></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="document in filteredDocuments" @mouseover.prevent="hoverId = document.id">
            <td>{{ document.name }}</td>
            <td>{{ document.source }}</td>
            <td>{{ document.sourceName }}</td>
            <td>{{ document.type }}</td>
            <td>{{ document.version }}</td>
            <td>{{ document.frequence }}</td>
            <td>{{ document.lang }}</td>
            <td>{{ document.last_reception }}</td>
            <td>
              <a class="button is-info is-small is-outlined" @click.prevent="showRecepDoc = true">Valider la reception</a>
            </td>
          </tr>
        </tbody>
      </table>

    <AddDoc v-if="showAddDoc" @hideAddDoc="showAddDoc = false" @documentAdded="updateDocuments($event)"></AddDoc>

    <RecepDoc v-if="showRecepDoc" @hideRecepDoc="showRecepDoc = false" :id="hoverId" @documentRecepted="updateDocuments($event)"></RecepDoc>
  </div>
</template>

<script>
import AddDoc from './AddDoc';
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
                showAddDoc: false,
                showRecepDoc: false
            }
        },

        methods: {
            updateDocuments(event) {
              this.showAddDoc = false;
              this.showRecepDoc = false;
              this.documents = event;
            }
        },

        computed: {
            filteredDocuments() {
                if (this.filter == 'all')
                    return this.documents;
                else if (this.filter == 'quotidien')
                    return this.documents.filter(document => document.frequence == 'quotidien');
                else if (this.filter == 'hebdomadaire')
                    return this.documents.filter(document => document.frequence == 'hebdomadaire');
                else
                    return this.documents.filter(document => document.frequence == 'mensuel');
            }
        },

        mounted() {
            axios.get('/documents/index').then(response => this.documents = response.data);
        },

        components: {
            AddDoc,
            RecepDoc
        }
    }
</script>

<style scoped>

</style>
