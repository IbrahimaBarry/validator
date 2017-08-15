<template>
	<div>
		<table class="table">
		    <thead>
		      <tr>
		        <th><abbr title="nom">Nom</abbr></th>
		        <th><abbr title="source">E-mail</abbr></th>
		        <th><abbr title="source name">Rôle</abbr></th>
		        <th><abbr title="type">Permissions</abbr></th>
		        <th><abbr title="version">Team</abbr></th>
		      </tr>
		    </thead>
		    <tbody>
		      <tr v-for="user in users">
		        <td>{{ user.name }}</td>
		        <td>{{ user.email }}</td>
		        <td>{{ user.role }}</td>
		        <td>
		        	<span v-if="user.role == 'agent'" v-for="permission in user.permissions">
		        		{{ permission.name }}, 
		        	</span>
		        </td>
		        <td></td>
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
				}
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
</style>