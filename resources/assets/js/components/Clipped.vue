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
            <th><abbr title="nbrPage">Date clipping</abbr></th>
            <th><abbr title="userName">Nom du clippeur</abbr></th>
            <th><abbr title="nbrPage"></abbr></th>
            <th><abbr title="nbrPage"></abbr></th>
            <th><abbr title="nbrPage"></abbr></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="doc in filteredDocuments" @mouseover="detail = doc">
            <td>{{ doc.document.type }}</td>
            <td>{{ doc.document.name }}</td>
            <td>{{ doc.sourceDate }}</td>
            <td>{{ doc.nbrPage }}</td>
            <td>{{ doc.date_clipping }}</td>
            <td>{{ doc.user_clipping }}</td>
            <div v-if="doc.exported == false">
              <td><a class="button is-small is-outlined is-info" @click.prevent="addExport(doc.id)">Valider l'export</a></td>
              <td><a class="delete is-medium danger" @click.prevent="deleteClipped(doc.id)"></a></td>
            </div>
            <td v-else>
              <span class="icon">
                <i class="fa fa-check success"></i>
              </span>
            </td>
            <td><a class="button is-small is-success" @click.prevent="showModal = true">Détails</a></td>
          </tr>
        </tbody>
      </table>

      <div class="modal is-active" v-if="showModal">
        <div class="modal-background"></div>
        <div class="modal-content box">
          <table class="table">
            <thead>
              <tr>
                <th><abbr title="type">Détails du clipping</abbr></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Type du document</td>
                <td>{{ detail.document.type }}</td>
              </tr>
              <tr>
                <td>Nom du document</td>
                <td>{{ detail.document.name }}</td>
              </tr>
              <tr>
                <td>Date de publication</td>
                <td>{{ detail.sourceDate }}</td>
              </tr>
              <tr>
                <td>Nbr. de page</td>
                <td>{{ detail.nbrPage }}</td>
              </tr>
              <tr>
                <td>Date clipping</td>
                <td>{{ detail.date_clipping }}</td>
              </tr>
              <tr>
                <td>Nom du clippeur</td>
                <td>{{ detail.user_clipping }}</td>
              </tr>
              <tr>
                <td>Nombre de d'articles total</td>
                <td>{{ detail.nbrArtTotal }}</td>
              </tr>
              <tr>
                <td>Durée totale du clipping</td>
                <td>{{ detail.time }}</td>
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
            if (response.data.export)
              next();
            else
              next({path: from.path});
          })
        },

        data() {
            return {
                documents: [],

                filter: 'all',

                showModal: false,

                detail: {}
            }
        },

        methods: {
            addExport(id) {
              axios.get('/receptions/export/'+id)
                  .then(response => this.documents = response.data);
            },

            deleteClipped(id) {
              axios.get('/receptions/deleteClipping/'+id)
                  .then(response => this.documents = response.data);
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
            axios.get('/receptions/clipping').then(response => this.documents = response.data);
        }
    }
</script>

<style scoped>

</style>
