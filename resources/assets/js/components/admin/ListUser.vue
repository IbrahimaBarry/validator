<template>
	<div>
		<div class="notification is-success" v-if="notif == 'success'">
			<button class="delete" 	@click.prevent="notif = ''"></button>
			Utilisateur supprimé
		</div>

		<table class="table">
		    <thead>
		      <tr>
		        <th><abbr title="nom">Nom</abbr></th>
		        <th><abbr title="source">E-mail</abbr></th>
		        <th><abbr title="source name">Rôle</abbr></th>
		        <th><abbr title="type">Permissions</abbr></th>
		        <th><abbr></abbr></th>
		      </tr>
		    </thead>
		    <tbody>
		      <tr v-for="user in users" @mouseover.prevent="hoverId = user.id">
		        <td><router-link :to="{name: 'profile', params: {id: user.id}}">{{ user.name }}</router-link></td>
		        <td>{{ user.email }}</td>
		        <td>{{ user.role }}</td>
		        <td>
		        	<span v-if="user.role == 'agent'" v-for="permission in user.permissions">
		        		{{ permission.name }}, 
		        	</span>
		        </td>
		        <td>
		          <!-- <a @click.prevent="showUpdateUser(document)">
	                <span class="icon">
	                  <i class="fa fa-pencil"></i>
	                </span>
	              </a> -->
	              <a class="delete danger" @click.prevent="showDelete = true"></a>
		        </td>
		      </tr>
		    </tbody>
		</table>
	
		<nav class="pagination" v-if="pagination.last_page > 1">
		  <a class="pagination-previous" title="This is the first page" @click.prevent="fetch(pagination.prev_page_url)" 
		  :disabled="!pagination.prev_page_url">Precedent</a>
		  <a class="pagination-next" @click.prevent="fetch(pagination.next_page_url)" 
		  :disabled="!pagination.next_page_url">Page suivant</a>
		  <ul class="pagination-list">
		    <li>
	           <span class="pagination-ellipsis">Page</span>
	           <a class="pagination-link is-current">{{ pagination.current_page }}</a>
	        </li>
		    <li><span class="pagination-ellipsis">sur</span></li>
		    <li><a class="pagination-link">{{ pagination.last_page }}</a></li>
		  </ul>
		</nav>

		<!-- DELETE -->
      <div class="modal is-active" v-if="showDelete">
        <div class="modal-background"></div>
        <div class="modal-content box has-text-centered">
          <span class="icon is-large">
            <i class="fa fa-warning"></i>
          </span>
          <h4 class="title is-4">Êtes vous sûr de vouloir supprimer cet utilisateur?</h4>
          <a class="button is-small is-primary" @click.prevent="deleteUser">OUI</a>
          <a class="button is-small" @click.pervent="showDelete = false">NON</a>
        </div>
      </div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				users: {},

				pagination: {
					current_page: '',
					last_page: '',
					next_page_url: '',
					prev_page_url: '',
				},

				showDelete: false,
				showUpdateUser: false,
				hoverId: 0,
				notif: ''
			}
		},

		methods: {
			fetch(page) {
				var self = this;
				axios.get(page).then(function (response) {
					self.users = response.data.data;
					self.pagination.current_page = response.data.current_page;
					self.pagination.last_page = response.data.last_page;
					self.pagination.next_page_url = response.data.next_page_url;
					self.pagination.prev_page_url = response.data.prev_page_url;
				});
			},

			deleteUser() {
				var self = this;
				axios.get('/users/destroy/'+this.hoverId)
					.then(response => {
						this.notif = response.data;
						return axios.get('/users/all');
					})
					.then(response => {
						self.users = response.data.data;
						self.pagination.current_page = response.data.current_page;
						self.pagination.last_page = response.data.last_page;
						self.pagination.next_page_url = response.data.next_page_url;
						self.pagination.prev_page_url = response.data.prev_page_url;
						self.showDelete = false
					});
			}
		},

		mounted() {
			var self = this;
			axios.get('/users/all').then(function (response) {
				self.users = response.data.data;
				self.pagination.current_page = response.data.current_page;
				self.pagination.last_page = response.data.last_page;
				self.pagination.next_page_url = response.data.next_page_url;
				self.pagination.prev_page_url = response.data.prev_page_url;
			});
		}
	}
</script>

<style scoped>
	.pagination a {
		color: hsl(217, 71%, 53%)
	}
	.pagination-link.is-current {
	    background-color: hsl(217, 71%, 53%);
	    border-color: hsl(217, 71%, 53%);
	    color: hsl(0, 0%, 100%)
  	}

  .danger {
    background: hsl(348, 100%, 61%);
  }

  .fa-warning {
    padding: 14px;
    color: hsl(48, 100%, 67%);
    margin-bottom: 20px;
  }
</style>