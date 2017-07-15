<template>
	<div class="modal is-active">
	  <div class="modal-background"></div>
	  <div class="modal-card">
	    <header class="modal-card-head">
	      <p class="modal-card-title">Ajouter un document</p>
	      <button class="delete" @click="hideModal"></button>
	    </header>
	    <section class="modal-card-body">
	      	<div class="field">
			  <label class="label">Nom</label>
			  <p class="control">
			    <input class="input" type="text" placeholder="Text input" v-model="document.name">
			  </p>
			</div>

			<div class="field">
			  <label class="label">Source</label>
			  <p class="control">
			    <input class="input" type="text" placeholder="Text input" v-model="document.source">
			    <!-- <span class="icon is-small is-left">
			      <i class="fa fa-user"></i>
			    </span>
			    <span class="icon is-small is-right">
			      <i class="fa fa-check"></i>
			    </span>
			  </p>
			  <p class="help is-success">This username is available --></p>
			</div>

			<div class="field">
			  <label class="label">Source name</label>
			  <p class="control">
			    <input class="input" type="text" placeholder="Text input" v-model="document.sourceName">
			  </p>
			</div>

			<div class="field">
			  <label class="label">Type</label>
			  <p class="control">
			    <span class="select">
			      <select v-model="document.type">
			        <option disabled="">-- Choisir un type --</option>
			        <option value="journal">Journal</option>
			        <option value="magasine">Magasine</option>
			      </select>
			    </span>
			  </p>
			</div>

			<div class="field">
			  <label class="label">Version</label>
			  <p class="control">
			    <span class="select">
			      <select v-model="document.version">
			        <option disabled="">-- Choisir une version --</option>
			        <option value="papier">Papier</option>
			        <option value="electronique">Electronique</option>
			      </select>
			    </span>
			  </p>
			</div>

			<div class="field">
			  <label class="label">Fréquence</label>
			  <p class="control">
			    <span class="select">
			      <select v-model="document.frequence">
			        <option disabled="">-- Choisir une fréquence --</option>
			        <option value="quotidien">Quotidien</option>
			        <option value="hebdomadaire">Hebdomadaire</option>
			        <option value="mensuel">Mensuel</option>
			      </select>
			    </span>
			  </p>
			</div>

			<div class="field">
			  <label class="label">Langue</label>
			  <p class="control">
			    <span class="select">
			      <select v-model="document.lang">
			        <option disabled="">-- Choisir une langue --</option>
			        <option value="arabe">Arabe</option>
			        <option value="français">Français</option>
			        <option value="anglais">Anglais</option>
			      </select>
			    </span>
			  </p>
			</div>

	    </section>
	    <footer class="modal-card-foot">
	      <a class="button is-primary" @click.prevent="addDocument">Enregistrer</a>
	      <a class="button" @click="hideModal">Fermer</a>
	    </footer>
	  </div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				document: {
					name: '',
					source: '',
					sourceName: '',
					type: '',
					version: '',
					frequence: '',
					lang: ''
				}
			}
		},

        methods: {
        	hideModal() {
        		this.$emit('hideAddDoc');
        	},

        	addDocument() {
        		axios.post('/documents/store', this.document)
				  .then(response => this.$emit('documentAdded', response.data));
        	}
        }
    }
</script>