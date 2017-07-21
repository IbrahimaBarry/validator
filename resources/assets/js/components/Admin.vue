<template>
	<div>
		</section>
		<section class="section">
		    <div class="container">

		        <div class="columns">
			<div class="column is-one-quarter">
				<aside class="menu">
				  <p class="menu-label">
				    Administration
				  </p>
				  <ul class="menu-list">
				    <li><a class="is-active">Paramètres des equipes</a></li>
				    <li>
				      <a>Gérer les agents</a>
				      <ul>
				        <li><a>Liste des agents</a></li>
				        <li><a>Ajouter un agent</a></li>
				      </ul>
				    </li>
				  </ul>
				  <p class="menu-label">
				    Transactions
				  </p>
				  <ul class="menu-list">
				    <li><a>Payments</a></li>
				    <li><a>Transfers</a></li>
				    <li><a>Balance</a></li>
				  </ul>
				</aside>
			</div>

			<!-- Team -->
			<div class="column">
				<div class="columns">
					<div class="card column is-half">
					  <header class="card-header">
					    <p class="card-header-title">
					      Equipe n°1
					    </p>
					  </header>
					  <div class="card-content">
					    
					  </div>
					  <footer class="card-footer">
					    <p class="card-footer-item">
					      <span>
					        View on <a href="https://twitter.com/codinghorror/status/506010907021828096">Twitter</a>
					      </span>
					    </p>
					    <p class="card-footer-item">
					      <span>
					        Share on <a href="#">Facebook</a>
					      </span>
					    </p>
					  </footer>
					</div>
				</div>
			</div>
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
	.hero.is-info a:not(.button) {
		color: initial;
	}

	a.is-active {
		background: lightgrey;
		color: white
	}

	.menu-list a {
		color: initial;
	}
</style>