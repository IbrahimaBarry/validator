<template>
	<div>
		<p>{{time.mn}}mn : {{time.s}}s : {{time.ms}}ms</p>
		<span class="icon is-small">
		  <i :class="{'fa fa-play': true, 'disabled': state == 'start'}" @click.prevent="start"></i>
		</span>
		<span class="icon is-small">
		  <i :class="{'fa fa-pause': true, 'disabled': state == 'pause'}" @click.prevent="pause"></i>
		</span>
		<span class="icon is-small">
		  <i :class="{'fa fa-stop': true, 'disabled': state == 'stop'}" @click.prevent="stop"></i>
		</span>
		<span class="icon is-small">
		  <i :class="{'fa fa-undo': true, 'disabled': state == 'reset'}" @click.prevent="reset"></i>
		</span>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				time: {
					mn: 0,
					s: 0,
					ms: 0
				},
				t: '',
				state: ''
			}
		},
		methods: {
			update() {
				this.time.ms++;
				if (this.time.ms == 10) {
					this.time.ms = 0;
					this.time.s++;
				}
				if (this.time.s == 60) {
					this.time.s = 0;
					this.time.mn++
				}
			},

			start() {
				if (this.state != 'start') {
					this.state = 'start';
					this.t = setInterval(this.update, 100);
				}
			},

			pause() {
				if (this.state != 'pause') {
					this.state = 'pause';
					clearInterval(this.t);
				}
			},

			reset() {
				if (this.state != 'reset') {
					this.state = 'reset';
					clearInterval(this.t);
					this.time.mn = 0;
					this.time.s = 0;
					this.time.ms = 0;
				}
			},

			stop() {
				if (this.state != 'stop') {
					this.state = 'stop';
					clearInterval(this.t);
					this.$emit('endClipping', this.time);
					this.reset();
				}
			}
		}
	}
</script>

<style scoped>
	.disabled {
		opacity: 0.4;
		pointer-events: none;
	}

	.fa-play {
		color: #00d1b2;
		cursor: pointer;
	}

	.fa-pause {
		color: #ffdd57;
		cursor: pointer;
	}

	.fa-stop {
		color: #ff3860;
		cursor: pointer;
	}
</style>