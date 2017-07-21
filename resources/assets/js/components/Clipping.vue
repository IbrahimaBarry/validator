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
            <th><abbr title="nom">Nom</abbr></th>
          <th><abbr title="source">Source</abbr></th>
          <th><abbr title="source name">Source name</abbr></th>
          <th><abbr title="type">Type</abbr></th>
          <th><abbr title="page">Nombre de page</abbr></th>
          <th><abbr title="langue">Langue</abbr></th>
          <th><abbr title="action">Date de publication</abbr></th>
          <th><abbr title="action"></abbr></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="doc in filteredDocuments" @mouseover="affect(doc)">
            <td>{{ doc.document.name }}</td>
            <td>{{ doc.document.source }}</td>
            <td>{{ doc.document.sourceName }}</td>
            <td>{{ doc.document.type }}</td>
            <td>{{ doc.nbrPage }}</td>
            <td>{{ doc.document.lang }}</td>
            <td>{{ doc.sourceDate }}</td>
            <td v-if="doc.clipped == false"><a class="button is-small is-outlined is-info" @click.prevent="showAddModal = true">Valider le clipping</a></td>
            <td v-else>
              <span class="icon">
                <i class="fa fa-check success"></i>
              </span>
            </td>
            <td v-if="doc.clipped == true"><a class="button is-small is-success" @click.prevent="showModal = true">Détails</a></td>
          </tr>
        </tbody>
      </table>

      <div class="modal is-active" v-if="showAddModal === true">
        <div class="modal-background"></div>
        <div class="modal-card">
          <header class="modal-card-head">
            <p class="modal-card-title">Validation du clipping</p>
            <button class="delete" @click="showAddModal = false"></button>
          </header>

          <section class="modal-card-body">  
            <div class="field">
              <label class="label">Nombre d'articles total</label>
              <p class="control">
                <input class="input" type="text" placeholder="Saisir le nombre d'articles total" v-model="clipping.nbrArtTotal">
              </p>
            </div>

            <div class="field">
              <label class="label">Durée totale du clipping</label>
              <p class="control">
                <input class="input" type="text" placeholder="Saisir la durée totale du clipping" v-model="clipping.time">
              </p>
            </div>
          </section>

          <footer class="modal-card-foot">
            <a class="button is-primary" @click.prevent="addClipping(hoverId)">Valider</a>
            <a class="button" @click="showAddModal = false">Fermer</a>
          </footer>
        </div>
      </div>
      
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
            if (response.data.clipping)
              next();
            else
              next({path: from.path});
          })
        },

        data() {
            return {
                documents: [],

                clipping: {
                  nbrArtTotal: '',
                  time: ''
                },

                hoverId: 0,

                showAddModal: false,

                showModal: false,

                detail: {},

                filter: 'all'
            }
        },

        methods: {
            addClipping(id) {
              if (this.hoverId != 0) {
                axios.post('/receptions/clipping/'+id, this.clipping)
                    .then(response => this.documents = response.data);
                this.showAddModal = false;
              }
            },

            affect(doc) {
              this.detail = doc;
              this.hoverId = doc.id;
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
            axios.get('/receptions/clipping/agent').then(response => this.documents = response.data);
        }
    }
</script>

<style scoped>

</style>
