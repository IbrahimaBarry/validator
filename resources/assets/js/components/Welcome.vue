<template>
	<div>
		<div class="tabs container">
		  <ul>
		  	<router-link tag="li" to="/documents/reception" exact>
		  		<a>Reception</a>
	  		</router-link>
		    <router-link tag="li" to="/documents/scan">
		    	<a>Scanne</a>
	    	</router-link>
		    <router-link tag="li" to="/documents/import">
		    	<a>Import</a>
		    </router-link>
		    <router-link tag="li" to="/documents/affect">
			    <a>Affecter documents importés</a>
			</router-link>

			<router-link tag="li" to="/documents/clipping">
			    <a>Clipping</a>
			</router-link>

			<router-link tag="li" to="/documents/export">
			    <a>Export</a>
			</router-link>
		  </ul>
		</div>

		<section class="section">
		    <div class="container">
				<transition name="slideOutLeft" mode="out-in">
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
				
			}
		}
	}
</script>

<style scoped>
	.tabs li.is-active a {
	    border-bottom-color: hsl(217, 71%, 53%);
	    color: hsl(217, 71%, 53%);
	}

	.tabs:not(:last-child) {
	    margin-bottom: 0;
	}

	.tabs ul {
		margin-top: 10px;
	}

	.slideOutLeft-enter-active {
	  animation-name: slideOutLeft;
	}

	.slideOutLeft-leave-active {
	  animation-name: slideOutLeft reverse;
	}

	@keyframes slideOutLeft {
	  from {
	    transform: translate3d(0, 0, 0);
	  }

	  to {
	    visibility: hidden;
	    transform: translate3d(-100%, 0, 0);
	  }
	}
</style>