<template>
	<div class='container'>
	  <div class='load'>
	    <div class='load--dot'></div>
	    <div class='load--dot'></div>
	    <div class='load--dot'></div>
	    <div class='load--dot'></div>
	    <div class='load--dot'></div>
	    <div class='load--dot'></div>
	    <div class='load--text'></div>
	  </div>
	</div>
</template>

<script>
	export default {

	}
</script>

<style scoped>
	.container {
	  position: fixed;
	  height: 20vh;
	  width: 100vw;
	  font-family: Helvetica;
	}

	.load {
	  height: 20px;
	  width: 250px;
	  position: absolute;
	  top: 0;
	  bottom: 0;
	  left: 0;
	  right: 0;
	  margin: auto;
	}
	.load--dot {
	  animation-name: load;
	  animation-timing-function: ease-in-out;
	  animation-duration: 3s;
	  animation-iteration-count: infinite;
	  height: 20px;
	  width: 20px;
	  border-radius: 100%;
	  background-color: black;
	  position: absolute;
	  border: 2px solid white;
	}
	.load--dot:first-child {
	  background-color: #8cc759;
	  animation-delay: 0.5s;
	}
	.load--dot:nth-child(2) {
	  background-color: #8c6daf;
	  animation-delay: 0.4s;
	}
	.load--dot:nth-child(3) {
	  background-color: #ef5d74;
	  animation-delay: 0.3s;
	}
	.load--dot:nth-child(4) {
	  background-color: #f9a74b;
	  animation-delay: 0.2s;
	}
	.load--dot:nth-child(5) {
	  background-color: #60beeb;
	  animation-delay: 0.1s;
	}
	.load--dot:nth-child(6) {
	  background-color: #fbef5a;
	  animation-delay: 0s;
	}
	.load--text {
	  position: absolute;
	  top: 200%;
	  left: 0;
	  right: 0;
	  width: 4rem;
	  margin: auto;
	}
	.load--text:after {
	  content: "Chargement";
	  font-weight: bold;
	  animation-name: loadingText;
	  animation-duration: 3s;
	  animation-iteration-count: infinite;
	}

	@keyframes load {
	  15% {
	    transform: translateX(0);
	  }
	  45% {
	    transform: translateX(230px);
	  }
	  65% {
	    transform: translateX(230px);
	  }
	  95% {
	    transform: translateX(0);
	  }
	}
	@keyframes loadingText {
	  0% {
	    content: "Chargement";
	  }
	  25% {
	    content: "Chargement.";
	  }
	  50% {
	    content: "Chargement..";
	  }
	  75% {
	    content: "Chargement...";
	  }
	}

</style>