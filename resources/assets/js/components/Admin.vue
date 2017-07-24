<template>
	<div>
		</section>
		<section class="section">
		    <div class="container columns">
		    	<div class="column is-offset-one-quarter is-half">
					<h2 class="title">Ajouter un utilisateur</h2>
					<div class="notification is-success" v-if="etat == 'success'">
						<button class="delete" 	@click.prevent="etat = ''"></button>
						Utilisateur ajouter avec succès
					</div>
					<form action="" @submit.prevent="addUser">
		    		<div class="field">
					  <label class="label">Nom</label>
					  <div class="control has-icons-left">
					    <input class="input" type="text" placeholder="Nom et prénom" v-model="user.name" required>
					    <span class="icon is-small is-left">
					      <i class="fa fa-user"></i>
					    </span>
					  </div>
					</div>

					<div class="field">
					  <label class="label">E-mail</label>
					  <div class="control has-icons-left">
					    <input class="input" type="email" placeholder="Saisir l'e-mail" v-model="user.email" required>
					    <span class="icon is-small is-left">
					      <i class="fa fa-envelope"></i>
					    </span>
					  </div>
					</div>

					<div class="field">
					  <label class="label">Mot de passe</label>
					  <div class="control has-icons-left">
					    <input class="input" type="password" placeholder="Saisir le mot de passe" v-model="user.password" required>
					    <span class="icon is-small is-left">
					      <i class="fa fa-key"></i>
					    </span>
					  </div>
					</div>

					<div class="field">
					  <label class="label">Confirmer mot de passe</label>
					  <div class="control has-icons-left has-icons-right">
					    <input :class="{'input': true, 'is-danger': confirmedPassword == false}" type="password" placeholder="Confirmer le mot de passe" v-model="user.password_confirmation" required>
					    <span class="icon is-small is-left">
					      <i class="fa fa-key"></i>
					    </span>
					    <div v-if="confirmedPassword == false">
						    <span class="icon is-small is-right">
						      <i class="fa fa-warning"></i>
						    </span>
						    <p class="help is-danger">Mots de passe différents</p>
					    </div>
					  </div>
					</div>

					<div class="field">
					  <label class="label">Rôle</label>
					  <div class="control">
					    <div class="select">
					      <select v-model="user.role" required>
					        <option disabled>Select role</option>
					        <option value="admin">Admin</option>
					        <option value="agent">Agent</option>
					      </select>
					    </div>
					  </div>
					</div>

					<div class="field">
					  <div class="control">
					    <label class="checkbox" v-if="user.role === 'agent'">
					      <input type="checkbox" value="1" v-model="user.permissions">
					      Reception
					    </label>
					    <label class="checkbox" v-if="user.role === 'agent'">
					      <input type="checkbox" value="2" v-model="user.permissions">
					      Scan
					    </label>
					    <label class="checkbox" v-if="user.role === 'agent'">
					      <input type="checkbox" value="3" v-model="user.permissions">
					      Import
					    </label>
					    <label class="checkbox" v-if="user.role === 'agent'">
					      <input type="checkbox" value="4" v-model="user.permissions">
					      Clipping
					    </label>
					    <label class="checkbox" v-if="user.role === 'agent'">
					      <input type="checkbox" value="5" v-model="user.permissions">
					      Export
					    </label>
					  </div>
					  <p v-if="permissionsNotChecked" class="help is-danger">Vous devez choisir une permisison</p>
					</div>

					<div class="field is-grouped">
					  <div class="control">
					    <button class="button is-primary">Ajouter</button>
					  </div>
					</div>
					</form>
		    	</div>
		    </div>
		</section>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				user: {
					name: '',
					email: '',
					password:  '',
					password_confirmation: '',
					role: '',
					permissions: []
				},

				etat: ''
			}
		},

		computed: {
			confirmedPassword() {
				if (this.user.password != '' && this.user.password_confirmation != '') {
					return this.user.password == this.user.password_confirmation;
				}
				else
					return true;
			},

			permissionsNotChecked() {
				if (this.user.role === 'agent')
					return this.user.permissions.length == 0;
				else 
					return false;
			}
		},

		methods: {
			addPermssions(val) {
				this.user.permissions.push(val);
			},

			addUser() {
				if (this.confirmedPassword && this.permissionsNotChecked == false) {
					axios.post('/user/store', this.user).then(response => this.etat = response.data)
				}
			}
		}
	}
</script>

<style scoped>
	section, .container h2.title {
		color: black
	}

	.checkbox {
		margin-right: 7px;
	}
</style>