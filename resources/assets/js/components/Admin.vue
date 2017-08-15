<template>
	<div>
		</section>
		<section class="section">
		    <div class="container columns">
		    	<aside class="menu column is-2">
				  <p class="menu-label">
				    General
				  </p>
				  <ul class="menu-list">
				    <li><a>Tableau de bord</a></li>
				    <li>
				    	<router-link tag="a" to="/admin/documents" exact>
				      		Documents
				      	</router-link>
					  </li>
				  </ul>
				  <p class="menu-label">
				    Administration
				  </p>
				  <ul class="menu-list">
				    <li>
				    	<router-link tag="a" to="/admin/teams" exact>
				      		Planning des équipes
				      	</router-link>
				    </li>
				  </ul>
				  <ul class="menu-list">
				    <li>
				      <a>Gestion utilisateurs</a>
				      <ul>
					      <li>
					      	<router-link tag="a" to="/admin/ListUser" exact>
					      		Liste utilisateurs
					      	</router-link>
					      </li>
					      <li>
					      	<router-link tag="a" to="/admin/addUser">
					      		Ajout utilisateur
					      	</router-link>
					      </li>
				      </ul>
				    </li>
				  </ul>
				</aside>
		    	<div class="column">
		    		<router-view></router-view>
		    	</div>
		    </div>
		</section>
	</div>
</template>

<script>
	export default {
		
	}
</script>

<style scoped>
	section {
		color: black
	}

	.menu-list a.is-active, .menu-list a.is-active:hover {
		background: #2196F3;
		color: white;
	}

	.menu-list a:hover {
		color: #2196F3;
	}
</style>