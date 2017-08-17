<template>
	<div class="modal is-active">
	  <div class="modal-background"></div>
	  <div class="modal-card">
	    <header class="modal-card-head has-text-centered">
	      <p class="modal-card-title">
	      	<ul id="progressbar">
			    <li :class="{'active': step == 1, 'completed': step > 1}">Documents à receptionner</li>
			    <li :class="{'active': step == 2, 'completed': step > 2}">Saisie des informations</li>
			    <li :class="{'active': step == 3, 'completed': step > 3}">Terminer</li>
			</ul>
	      </p>
	      <button class="delete" @click="hideModal"></button>
	    </header>
	    <section class="modal-card-body">
	        <!-- Step 1 -->
	        <div v-show="step == 1">
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
		          	<th>
		          		<div class="field">
						  <p class="control checkbox">
					      	<input type="checkbox" id="all" v-model="selectAll">
						    <label for="all"></label>
						  </p>
						</div>
		          	</th>
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
		          <tr v-for="document in sortedDocuments">
		          	<td>
		          		<div class="field">
						  <p class="control checkbox">
					      	<input type="checkbox" :id="document.id" :value="document" v-model="selected">
						    <label :for="document.id"></label>
						  </p>
						</div>
		          	</td>
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
		    </div>

		    <!-- Step 2 -->
	      	<table v-show="step == 2" id="table" class="table">
		        <thead>
		          <tr>
		            <th><abbr title="type">Type</abbr></th>
		            <th><abbr title="nom">Nom</abbr></th>
		            <th><abbr title="source">Source</abbr></th>
		            <th><abbr title="source name">Source name</abbr></th>
		            <th><abbr title="lang">Langue</abbr></th>
		            <th><abbr title="sourceDate">Date de publication</abbr></th>
		            <th><abbr title="nbrPage">Nombre de page</abbr></th>
		            <th><abbr title="version">Cause du retard</abbr></th>
		          </tr>
		        </thead>
		        <tbody>
		          <tr v-for="document in selected" @mouseover.prevent="hoverId = document.id">
		            <td>{{ document.type }}</td>
		            <td>{{ document.name }}</td>
		            <td>{{ document.source }}</td>
		            <td>{{ document.sourceName }}</td>
		            <td>{{ document.lang }}</td>
		            <td>
		            	<div class="control">
						  <input class="input" name="sourceDate" type="date" :value="today" @input="update(document.id, $event)">
						</div>
		            </td>
		            <td>
		          		<div class="control">
						  <input class="input" name="nbrPage" type="number" @blur="update(document.id, $event)">
						</div>
		          	</td>
		            <td>
		            	<div class="field">
						  <div class="control">
						    <div class="select">
						      <select name="message" @change="update(document.id, $event)">
						        <option disabled>Select cause du retard</option>
						        <option>Aucune</option>
						        <option value="Retard reception">Retard reception</option>
						        <option value="Retard publication">Retard publication</option>
						        <option value="Perte document">Perte document</option>
						        <option>Autre</option>
						      </select>
						    </div>
						  </div>
						</div>
		            </td>
		          </tr>
		        </tbody>
		    </table>

		    <!-- Step 3 -->
		    <p v-show="step == 3" class="subtitle is-4 has-text-centered">
		    	Clickez sur terminer pour enregistrer les receptions <br><br>
		    	Revenez en arrière pour modifier
		    </p>

	    </section>
	    <footer class="modal-card-foot">
	      <a v-if="step != 1" class="button" @click.prevent="back"><i class="fa fa-angle-double-left"></i></a>
	      <a v-if="step < 3" class="button" @click.prevent="next"><i class="fa fa-angle-double-right"></i></a>
	      <a v-else class="button is-info" @click.prevent="addReception">Terminer</a>
	      <a class="button" @click="hideModal">Annuler</a>
	    </footer>
	  </div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				documents: [],
				selected: [],
				step: 1,
				filter: 'all',
				search: '',
                type: 'Type',
                lang: 'Langue',
                version: 'Version',

                today: ''
			}
		},

		methods: {
			hideModal() {
				this.$emit('hideRecepDoc');
			},

			addReception() {
				if (this.receptions.length > 0) {
						axios.post('/receptions/store', this.receptions)
							.then(response => this.$emit('documentRecepted'));
				}
        	},

        	next() {
        		if (this.step < 3)
        			this.step += 1;
        	},

        	back() {
        		if (this.step > 1)
        			this.step -= 1;
        	},

        	update(id, event) {
        		this.receptions.forEach(function(el) {
        			if (el.document_id == id) {
        				if (event.target.name == 'sourceDate')
        					el.sourceDate = event.target.value;
        				else if (event.target.name == 'nbrPage')
        					el.nbrPage = event.target.value;
        				else
        					el.message = event.target.value;
        			}
        				
        		})
        	},

        	reload() {
              this.search = ''; this.type = 'Type'; this.lang = 'Langue'; this.version = 'Version';
            }
		},

		computed: {
			selectAll: {
				get() {
					return this.sortedDocuments ? this.selected.length == this.sortedDocuments.length : false;
				},
				set(value) {
					if (value) {
						var selected = [];
						this.sortedDocuments.forEach(function (el) {
							selected.push(el);
						});
					}

					this.selected = selected;
				}
			},

			filteredDocuments() {
                if (this.filter == 'all')
                    return this.documents;
                else if (this.filter == 'Quotidien')
                    return this.documents.filter(document => document.frequence == 'Quotidien');
                else if (this.filter == 'Hebdomadaire')
                    return this.documents.filter(document => document.frequence == 'Hebdomadaire');
                else
                    return this.documents.filter(document => document.frequence == 'Mensuel');
            },

            sortedDocuments() {
              var temp;
                if (this.search == '')
                  temp = this.filteredDocuments;
                else
                  temp = this.filteredDocuments.filter(document => document.name == this.search);

                if (this.type != 'Type')
                  temp = temp.filter(document => document.type == this.type);
                if (this.lang != 'Langue')
                  temp = temp.filter(document => document.lang == this.lang);
                if (this.version != 'Version')
                  temp = temp.filter(document => document.version == this.version);

                return temp;
            },

			receptions() {
				var tab = [];
				this.selected.forEach(function(el) {
					tab.push({sourceDate: today(),
									nbrPage: 0,
										document_id: el.id,
											message: ''});

				});
				return tab;
			}
		},

		mounted() {
			var self = this;
			axios.get('documents/index')
				.then(function (response){
					self.documents = response.data;
					self.today = today();
				});
		}
    }
</script>

<style scoped>
	label.checkbox {
		color: black
	}

	.modal-card {
		width: 95%
	}

	.modal-card-head {
		background: white
	}

	#progressbar {
		/*CSS counters to number the steps*/
		counter-reset: step;
		font-size: 15px;
	}
	#progressbar li {
		list-style-type: none;
		color: black;
		width: 33.33%;
		float: left;
		position: relative;
	}
	#progressbar li:before {
		content: counter(step);
		counter-increment: step;
		width: 30px;
		height: 30px;
		line-height: 28px;
		border: 1px solid #ddd;
		border-radius: 50%;
		display: block;
		text-align: center;
		background: white;
		margin: 0 auto 5px auto;
	}
	/*progressbar connectors*/
	/*#progressbar li:after {
		content: '';
		position: absolute;
		width: 100%;
		height: 1px;
		background: #ddd;
		left: -50%;
		top: 15px;
	}*/
	#progressbar li:first-child:after {
		/*connector not needed before the first step*/
		content: none; 
	}
	#progressbar li.active, #progressbar li.completed {
		color: hsl(217, 71%, 53%)
	}
	#progressbar li.active:before {
		border-color: hsl(217, 71%, 53%)
	}
	#progressbar li.active + li:after, #progressbar li.completed + li:after{
		background: hsl(217, 71%, 53%);
	}
	#progressbar li.completed:before{
		background: hsl(217, 71%, 53%);
		color: hsl(0, 0%, 100%)
	}

	.checkbox {
		width: 20px;
		height: 20px;
		background: #ddd;
		position: relative;
	}
	.checkbox input[type="checkbox"] {
		visibility: hidden;
	}
	.checkbox label {
		width: 18px;
		height: 18px;
		position: absolute;
		top: 1px;
		left: 1px;
		background: white;
		cursor: pointer;
	}
	.checkbox label:before {
		content: '';
		width: 9px;
		height: 5px;
		border: 3px solid white;
		position: absolute;
		border-top: none;
		border-right: none;
		transform: rotate(-45deg);
		top: 5px;
		left: 5px;
		opacity: 0
	}
	.checkbox input[type="checkbox"]:checked + label:before {
		opacity: 1;
	}
	.checkbox input[type="checkbox"]:checked + label {
		background: hsl(217, 71%, 53%);
	}
</style>