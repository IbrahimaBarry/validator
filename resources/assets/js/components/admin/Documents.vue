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
        <p class="level-item"><a class="button is-info is-outlined" @click.prevent="showAddDoc = true">Ajouter un document</a></p>
      </div>
    </nav>
    
    <table class="table is-striped">
        <thead>
          <tr>
            <th><abbr title="type">Type</abbr></th>
            <th><abbr title="nom">Nom</abbr></th>
            <th><abbr title="source">Source</abbr></th>
            <th><abbr title="source name">Source name</abbr></th>
            <th><abbr title="langue">Langue</abbr></th>
            <th><abbr title="version">Version</abbr></th>
            <th><abbr title="frequence">Fréquence</abbr></th>
            <th><abbr title="emplacement">Emplacement</abbr></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="document in filteredDocuments" @mouseover.prevent="hoverId = document.id">
            <td>{{ document.type }}</td>
            <td>{{ document.name }}</td>
            <td>{{ document.source }}</td>
            <td>{{ document.sourceName }}</td>
            <td>{{ document.lang }}</td>
            <td>{{ document.version }}</td>
            <td>{{ document.frequence }}</td>
            <td>{{ document.location }}</td>
          </tr>
        </tbody>
      </table>

    <AddDoc v-if="showAddDoc" @hideAddDoc="showAddDoc = false" @documentAdded="updateDocuments($event)"></AddDoc>
  </div>
</template>

<script>
    import AddDoc from './AddDoc';

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
            filteredDocuments: {
              get() {
                if (this.filter == 'all')
                    return this.documents;
                else if (this.filter == 'Quotidien')
                    return this.documents.filter(document => document.frequence == 'Quotidien');
                else if (this.filter == 'Hebdomadaire')
                    return this.documents.filter(document => document.frequence == 'Hebdomadaire');
                else
                    return this.documents.filter(document => document.frequence == 'Mensuel');
                }, 
              
              set() {
                
              }
            }
        },

        mounted() {
            axios.get('/documents/index').then(response => this.documents = response.data);
        },

        components: {
            AddDoc
        }
    }
</script>

<style scoped>

</style>
