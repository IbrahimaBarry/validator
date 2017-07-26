<template>
	<div>
		  <div class="hero-foot">
		    <nav class="tabs is-boxed">
		      <div class="container">
		        <ul>
		            <router-link tag="li" to="/documents" exact>
					    <a>Documents</a>
					</router-link>

					<router-link tag="li" to="/documents/reception">
					    <a>Documents à scanner</a>
					</router-link>

					<router-link tag="li" to="/documents/scan">
					    <a>Documents à impoter</a>
					</router-link>

					<router-link tag="li" to="/documents/import">
					    <a>Affecter documents importés</a>
					</router-link>

					<router-link tag="li" to="/documents/clipping">
					    <a>Documents à clipper</a>
					</router-link>

					<router-link tag="li" to="/documents/clipped">
					    <a>Documents clippés</a>
					</router-link>
		        </ul>
		      </div>
		    </nav>
		  </div>
		</section>

		<section class="section">
		    <div class="container">
				<transition name="fade" mode="out-in">
		        	<router-view></router-view>
		        </transition>
		    </div>
		</section>
  	</div>
</template>

<script>
	export default {
		data() {
			return {
				user: {},
				scan: '',
				import: '',
				clipping: '',
				export: ''
			}
		}
	}
</script>

<style>

	/*.fade-enter-active {
	  animation: fade .5s;
	}
	.fade-leave-active {
	  animation: fade .5s reverse;
	}
	@keyframes fade {
	  0% {
		opacity: 0
	  }
	  50% {
		opacity: 0.5
	  }
	  100% {
		opacity: 1
	  }
	}*/
</style>