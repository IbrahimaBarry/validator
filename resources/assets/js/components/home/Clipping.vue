<template>
    <div>
      <nav class="level">
      <!-- Left side -->
      <div class="level-left">
        <div class="level-item">
          <p class="subtitle is-5">
            <strong>{{sortedDocuments.length}}</strong> Documents
          </p>
        </div>
        <div class="level-item">
          <div class="field has-addons">
            <p class="control">
              <input class="input" type="text" placeholder="Rechercher..." @keyup.enter="search = $event.target.value">
            </p>
            <div class="control">
              <div class="select">
                <select v-model="type">
                  <option>Type</option>
                  <option value="Magasine">Magasine</option>
                  <option value="Journal">Journal</option>
                </select>
              </div>
            </div>
            <div class="control">
              <div class="select">
                <select v-model="lang">
                  <option>Langue</option>
                  <option value="Anglais">Anglais</option>
                  <option value="Arabe">Arabe</option>
                  <option value="Français">Français</option>
                  <option value="Tamazight">Tamazight</option>
                </select>
              </div>
            </div>
            <div class="control">
              <div class="select">
                <select v-model="version">
                  <option>Version</option>
                  <option value="Papier">Papier</option>
                  <option value="Electronique">Electronique</option>
                </select>
              </div>
            </div>
            <p class="control"><button class="button is-info is-inverted" @click.prevent="reload"><i class="fa fa-refresh" aria-hidden="true"></i></button></p>
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
      
      <table class="table">
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
          <tr v-for="doc in sortedDocuments" @mouseover="affect(doc)">
            <td>{{ doc.document.name }}</td>
            <td>{{ doc.document.source }}</td>
            <td>{{ doc.document.sourceName }}</td>
            <td>{{ doc.document.type }}</td>
            <td>{{ doc.nbrPage }}</td>
            <td>{{ doc.document.lang }}</td>
            <td>{{ doc.sourceDate }}</td>
            <td v-if="doc.clipped == false">
              <!-- <a class="button is-small is-outlined is-info" @click.prevent="showAddModal = true">Valider le clipping</a> -->
              <div class="chrono"><Chrono @endClipping="endClipping"></Chrono></div>
            </td>
            <div v-else>
              <td>
                <span class="icon">
                  <i class="fa fa-check success"></i>
                </span>
              </td>
              <td><a class="button is-small is-info" @click.prevent="showModal = true">Détails</a></td>
            </div>
          </tr>
        </tbody>
        <tfoot>
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
        </tfoot>
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
                <input class="input" type="number" placeholder="Saisir le nombre d'articles total" v-model="clipping.nbrArtTotal">
              </p>
            </div>

            <div class="field">
              <label class="label">Durée totale du clipping</label>
              <p class="control">
                <input class="input" type="text" disabled v-model="clipping.time">
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
    import Chrono from './Chrono';
    export default {
        beforeRouteEnter (to, from, next) {
          axios.get('/user').then(function(response) {
            if (response.data.clipping)
              next();
            else
              next({path: from.path});
          })
        },

        components: {
          Chrono
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
                filter: 'all',
                search: '',
                type: 'Type',
                lang: 'Langue',
                version: 'Version'
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
            },

            endClipping(event) {
              this.showAddModal = true;
              this.clipping.time = event.mn+'mn:'+event.s+'s:'+event.ms+'ms';
            },

            reload() {
              this.search = ''; this.type = 'Type'; this.lang = 'Langue'; this.version = 'Version';
            }
        },

        computed: {
            filteredDocuments() {
                if (this.filter == 'all')
                    return this.documents;
                else if (this.filter == 'Quotidien')
                    return this.documents.filter(doc => doc.document.frequence == 'Quotidien');
                else if (this.filter == 'Hebdomadaire')
                    return this.documents.filter(doc => doc.document.frequence == 'Hebdomadaire');
                else
                    return this.documents.filter(doc => doc.document.frequence == 'Mensuel');
            },

            sortedDocuments() {
              var temp;
                if (this.search == '')
                  temp = this.filteredDocuments;
                else
                  temp = this.filteredDocuments.filter(document => document.document.name == this.search);

                if (this.type != 'Type')
                  temp = temp.filter(document => document.document.type == this.type);
                if (this.lang != 'Langue')
                  temp = temp.filter(document => document.document.lang == this.lang);
                if (this.version != 'Version')
                  temp = temp.filter(document => document.document.version == this.version);

                return temp;
              }
        },

        mounted() {
            axios.get('/receptions/clipping/agent').then(response => this.documents = response.data);
        }
    }
</script>

<style scoped>
  .chrono {
    width: 130px
  }
</style>
