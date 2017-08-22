<template>
	<div>
		<div class="tile is-ancestor">
		  <div class="tile is-4 is-vertical is-parent">
		    <div class="tile is-child notification is-info">
		      <p class="title is-5 has-text-centered">{{user.name.toUpperCase()}}</p>
		      <hr>
		      <div class="content">
			      <p>Email : {{user.email}}</p>
			      <p>Rôle : {{user.role.toUpperCase()}}</p>
			      <p v-if="user.role == 'agent'">Permission : 
			      	<span v-for="permission in user.permissions">{{permission.name.toUpperCase()}}, </span>
			      </p>
			  </div>
		    </div>
		    <div class="tile is-child notification is-warnning">
		      <p class="title is-5 has-text-centered">Edite profile</p>
		      <hr>
		      <p></p>
		    </div>
		  </div>
		  <div class="tile is-parent">
		    <div class="tile is-child notification">
		      <p class="title is-5 has-text-centered">Statistiques</p>
		      <hr>
		      <div class="content">
		      	<!-- <p>Nombre de documents scannés : {{documents.filter(doc => doc.user_scan == user.name).length}}</p>
		      	<p>Nombre de documents OCR : {{documents.filter(doc => doc.user_ocr == user.name).length}}</p>
		      	<p>Nombre de documents importés : {{documents.filter(doc => doc.user_import == user.name).length}}</p>
		      	<p>Nombre de documents clippés : {{documents.filter(doc => doc.user_clipping == user.name).length}}</p>
		      	<p>Nombre de documents exportés : {{documents.filter(doc => doc.user_export == user.name).length}}</p> -->
		      </div>
		    </div>
		  </div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				user: {},
				documents: []
			}
		},

		mounted() {
			var self = this;
			axios.get('/user/'+this.$route.params.id).then(response => {
				self.user = response.data.user;
				self.documents = response.data.documents
			})
		}
	}
</script>

<style scoped>
	.content {
		line-height: 30px
	}
</style>