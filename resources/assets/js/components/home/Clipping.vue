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
      
    <Loader v-if="loading"></Loader>
    <div v-else>
      <table :class="{table: true, loading: loading}">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Source</th>
            <th>Source name</th>
            <th>Type</th>
            <th>Nombre de page</th>
            <th>Langue</th>
            <th>Date de publication</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="doc in sortedDocuments">
            <td>{{ doc.import.scan.reception.document.name }}</td>
            <td>{{ doc.import.scan.reception.document.source }}</td>
            <td>{{ doc.import.scan.reception.document.sourceName }}</td>
            <td>{{ doc.import.scan.reception.document.type }}</td>
            <td>{{ doc.import.scan.reception.nbrPage }}</td>
            <td>{{ doc.import.scan.reception.document.lang }}</td>
            <td>{{ doc.import.scan.reception.sourceDate }}</td>
            <div v-if="doc.clipped">
              <td v-if="doc.confirmed">
                <span class="icon">
                  <i class="fa fa-check success"></i>
                </span>
              </td>
              <div v-else>
                <td v-if="role == 'agent'">En attente...</td>
                <td v-else>
                  <a class="button is-small is-primary is-outlined" @click.prevent="confirm(doc)">Confirmer</a>
                </td>
              </div>
            </div>
            <td v-else>
              <!-- <div class="chrono"><Chrono @endClipping="endClipping"></Chrono></div> -->
              <a class="button is-small is-info is-outlined" @click.prevent="startClipping(doc)">Démarrer le clipping</a>
            </td>
            <td>
              <a class="button is-small" @click.prevent="showDetail = true">Details</a>
              <Detail :document="doc" v-if="showDetail" @closeDetail="showDetail = false"></Detail>
            </td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <th>Nom</th>
            <th>Source</th>
            <th>Source name</th>
            <th>Type</th>
            <th>Nombre de page</th>
            <th>Langue</th>
            <th>Date de publication</th>
            <th></th>
          </tr>
        </tfoot>
      </table>
    </div>

      <div class="modal is-active" v-if="showModal === true">
        <div class="modal-background"></div>
        <div class="modal-card">
          <header class="modal-card-head">
            <p class="modal-card-title">Validation du clipping</p>
            <button class="delete" @click="showModal = false"></button>
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
                <input class="input" type="time" v-model="clipping.time">
              </p>
            </div>
          </section>

          <footer class="modal-card-foot">
            <a class="button is-primary" @click.prevent="doneClipping">Valider</a>
            <a class="button" @click="showModal = false">Fermer</a>
          </footer>
        </div>
      </div>
    </div>
</template>

<script>
import Detail from './Detail';
import Loader from '../Loader';

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
          Detail,
          Loader
        },

        data() {
            return {
                role: '',
                documents: [],
                clipping: null,
                showModal: false,
                showDetail: false,
                filter: 'all',
                search: '',
                type: 'Type',
                lang: 'Langue',
                version: 'Version',

                loading: false
            }
        },

        methods: {
            startClipping(doc) {
              this.clipping = doc;
              this.showModal = true;
            },

            doneClipping() {
              this.loading = true;
              var self = this;
              axios.post('/clipping', this.clipping)
                .then(response => {
                  self.clipping.clipped = true;
                  self.showModal = false;
                  self.loading = false;
                });
            },

            confirm(doc) {
              this.loading = true;
              var self = this;
              axios.get('/clipping/confirm/'+doc.id)
                .then(response => {
                  doc.confirmed = true;
                  self.loading = false;
                });
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
                    return this.documents.filter(doc => doc.import.scan.reception.document.frequence == 'Quotidien');
                else if (this.filter == 'Hebdomadaire')
                    return this.documents.filter(doc => doc.import.scan.reception.document.frequence == 'Hebdomadaire');
                else
                    return this.documents.filter(doc => doc.import.scan.reception.document.frequence == 'Mensuel');
            },

            sortedDocuments() {
              var temp;
                if (this.search == '')
                  temp = this.filteredDocuments;
                else
                  temp = this.filteredDocuments.filter(doc => doc.import.scan.reception.document.name == this.search);

                if (this.type != 'Type')
                  temp = temp.filter(doc => doc.import.scan.reception.document.type == this.type);
                if (this.lang != 'Langue')
                  temp = temp.filter(doc => doc.import.scan.reception.document.lang == this.lang);
                if (this.version != 'Version')
                  temp = temp.filter(doc => doc.import.scan.reception.document.version == this.version);

                return temp;
              }
        },

        mounted() {
            this.loading = true;
            var self = this;
            axios.get('/clipping/index')
              .then(response => {
                self.documents = response.data.clippings;
                self.role = response.data.role;
                self.loading = false;
              });
        }
    }
</script>

<style scoped>
  .chrono {
    width: 130px
  }
</style>
