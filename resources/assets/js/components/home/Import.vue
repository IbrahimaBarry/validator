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
        <p class="level-item">
          <a class="button is-info is-outlined" @click.prevent="showRecepDoc = true">Reception</a>
          </p>
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
            <tr v-for="scan in sortedDocuments">
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
                filter: 'all',
                search: '',
                type: 'Type',
                lang: 'Langue',
                version: 'Version'
            }
        },

        methods: {
            addImport(id) {
              axios.get('/receptions/import/'+id)
                  .then(response => this.scans = response.data);
            },

            reload() {
              this.search = ''; this.type = 'Type'; this.lang = 'Langue'; this.version = 'Version';
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
            axios.get('/receptions/getScanned').then(response => this.scans = response.data);
        }
    }
</script>

<style scoped>

</style>
