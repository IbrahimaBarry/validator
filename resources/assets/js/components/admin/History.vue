<template>
	<div>
		<table :class="{table: true, loading: loading}">
          <thead>
            <tr>
              <th>Type</th>
              <th>Description</th>
              <th>Agent</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="history in histories">
              <td>{{ history.type }}</td>
              <td>{{ history.description }}</td>
              <td>{{ history.user.name }}</td>
            </tr>
          </tbody>
        </table>

        <!-- PAGINATION -->
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
				histories: [],
				pagination: {
                  current_page: '',
                  last_page: '',
                  next_page_url: '',
                  prev_page_url: '',
                },
			}
		},

		methods: {
			paginate(pages) {
              this.pagination.current_page = pages.current_page;
              this.pagination.last_page = pages.last_page;
              this.pagination.next_page_url = pages.next_page_url;
              this.pagination.prev_page_url = pages.prev_page_url;
            },

            fetch(page) {
                var self = this;
                axios.get(page).then(function (response) {
                  self.histories = response.data.data;
                  self.paginate(response.data);
                });
            }
		},

		mounted() {
			var self = this;
			axios.get('/admin/histories').then(response => {
				self.histories = response.data.data;
				self.paginate(response.data);
			});
		}
	}
</script>