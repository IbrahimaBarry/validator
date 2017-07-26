<template>
	<table class="table is-striped">
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
</template>

<script>
	export default {
		data() {
			return {
				users: {}
			}
		},

		mounted() {
			axios.get('/users/all').then(response => this.users = response.data);
		}
	}
</script>