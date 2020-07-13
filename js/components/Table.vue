<template>
	<div class="table-container">
		<table class="table is-striped">
			<thead>
				<th v-if="isAdmin"><input type="checkbox" v-model="all" /></th>
				<th v-for="row of displayedRows" :key="row.name" @click="sort(row.name)">
					<span>{{ row.display }}</span>
					<span class="icon is-small">
						<i
							class="fas"
							v-if="sortMethod == row.name"
							:class="{ 'fa-angle-down': sortReverse, 'fa-angle-up': !sortReverse }"
						></i>
					</span>
				</th>
			</thead>
			<tbody>
				<tr
					:is="rowType"
					v-for="(item, k) in sorted"
					:key="k"
					v-bind="item"
					v-on="$listeners"
					:is-admin="isAdmin"
					@select="$set(item, 'selected', !item.selected)"
				></tr>
			</tbody>
		</table>
	</div>
</template>

<script>
	import { sortBy } from "lodash";

	export default {
		props: {
			rows: { type: Array },
			data: { type: Array },
			rowType: { type: [Object, String] },
			isAdmin: { type: Boolean },
		},
		data() {
			return {
				sortMethod: null,
				sortReverse: null,
			};
		},
		computed: {
			displayedRows() {
				return this.rows.filter(row => {
					return typeof row.show == "function" ? row.show() : true;
				});
			},
			sorted() {
				if (!this.sortMethod) {
					return this.data;
				}
				const sorted = sortBy(this.data, this.sortMethod);
				if (this.sortReverse) {
					sorted.reverse();
				}
				return sorted;
			},
			selected() {
				return this.data.filter(item => item.selected);
			},
			all: {
				get() {
					return this.selected.length > this.data.length / 2;
				},
				set() {
					const all = !this.all;
					for (const item of this.data) {
						this.$set(item, "selected", all);
					}
				},
			},
		},
		methods: {
			sort(method) {
				if (this.sortMethod != method) {
					this.sortMethod = method;
					this.sortReverse = false;
				} else if (this.sortMethod == method) {
					this.sortReverse = !this.sortReverse;
				}
			},
		},
	};
</script>

<style></style>
