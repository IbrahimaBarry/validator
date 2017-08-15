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
			    <input class="input" type="text" placeholder="Saisir le nom du document" v-model="document.name">
			  </p>
			</div>

			<div class="field">
			  <label class="label">Source</label>
			  <p class="control">
			    <input class="input" type="text" placeholder="Saisir la source du document" v-model="document.source">
			  </p>
			</div>

			<div class="field">
			  <label class="label">Source name</label>
			  <p class="control">
			    <input class="input" type="text" placeholder="Saisir le sourceName du document" v-model="document.sourceName">
			  </p>
			</div>

			<div class="field">
			  <label class="label">Emplacement</label>
			  <p class="control">
			    <span class="select">
			      <select v-model="document.location">
			        <option disabled="">-- Choisir un emplacement --</option>
			        <option value="National">National</option>
			        <option value="International">International</option>
			      </select>
			    </span>
			  </p>
			</div>

			<div class="field">
			  <label class="label">Type</label>
			  <p class="control">
			    <span class="select">
			      <select v-model="document.type">
			        <option disabled="">-- Choisir un type --</option>
			        <option value="Journal">Journal</option>
			        <option value="Magasine">Magasine</option>
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
			        <option value="Papier">Papier</option>
			        <option value="Electronique">Electronique</option>
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
			        <option value="Quotidien">Quotidien</option>
			        <option value="Hebdomadaire">Hebdomadaire</option>
			        <option value="Mensuel">Mensuel</option>
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
			        <option value="Arabe">Arabe</option>
			        <option value="Anglais">Anglais</option>
			        <option value="Français">Français</option>
			        <option value="Tamazight">Tamazight</option>
			      </select>
			    </span>
			  </p>
			</div>

	    </section>
	    <footer class="modal-card-foot">
	      <a class="button is-primary" @click.prevent="updateDocument">Enregistrer</a>
	      <a class="button" @click="hideModal">Fermer</a>
	    </footer>
	  </div>
	</div>
</template>

<script>
	export default {
		props: ['initialDocument'],

		data() {
			return {
				document: {
					id: this.initialDocument.id,
					name: this.initialDocument.name,
					source: this.initialDocument.source,
					sourceName: this.initialDocument.sourceName,
					location: this.initialDocument.location,
					type: this.initialDocument.type,
					version: this.initialDocument.version,
					frequence: this.initialDocument.frequence,
					lang: this.initialDocument.lang
				}
			}
		},

        methods: {
        	hideModal() {
        		this.$emit('hideUpdateDoc');
        	},

        	updateDocument() {
        		axios.post('/documents/update/'+this.document.id, this.document)
        			.then(response => this.$emit('documentUpdated', response.data));
        	}
        }
    }
</script>