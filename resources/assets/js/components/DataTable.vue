<template>
    <div class="card">
        <div class="card-content">

            <span class="card-title">
                {{ this.title | capitalize }}

                <router-link
                        :to="{ name: this.endpoint + '.create' }"
                        v-if="actions.create"
                        class="waves-effect waves-light btn right">
                    <i class="material-icons right">add</i>create
                </router-link>
            </span>

            <table class="striped responsive-table">
                <thead>
                    <tr>
                        <th v-for="column in columns"
                            v-text="column.name"
                        ></th>
                        <th v-if="actions.edit"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in rows" @click="handleClick(row.id)">
                        <td v-for="column in columns">{{ dynamicFilter(column.filter, row[column.data_name]) }}</td>
                        <td width="150px" v-if="actions.edit">
                            <router-link v-if="!row.deleted" :to="{ name: endpoint + '.update', params: { id: row.id }}" class="waves-effect waves-white btn-small">
                                <i class="material-icons">edit</i>
                            </router-link>
                            <a v-if="!row.deleted" class="waves-effect waves-white btn-small" @click="$set(row, 'deleted', true)"><i class="material-icons">delete</i></a>
                            <a v-if="row.deleted" @click="deleteRow(row)" class="waves-effect waves-white btn red">Confirm</a>
                        </td>
                    </tr>
                </tbody>
            </table>

            <ul class="pagination" v-if="paginate">
                <li :class="[back ? 'waves-effect' : 'disabled']">
                    <a @click="move(current_page - 1)" href="#!"><i class="material-icons">chevron_left</i></a>
                </li>

                <li v-for="page in last_page" :class="{ 'active': current_page === page, 'waves-effect': current_page !== page}">
                    <a @click="move(page)" href="#!">{{ page }}</a>
                </li>

                <li :class="[forward ? 'waves-effect' : 'disabled']">
                    <a @click="move(current_page + 1)" href="#!"><i class="material-icons">chevron_right</i></a>
                </li>
            </ul>

            <div class="progress" v-show="loading">
                <div class="indeterminate"></div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            link_to_detail: {
                type: String,
                default: null
            },
            paginate: {
                type: Boolean,
                default: true
            },
            name: {
                type: String,
                default: null
            },
            columns: {
                required: true,
                type: Array
            },
            endpoint: {
                required: true,
                type: String
            },
            actions: {
                required: false,
                type: Object,
                default: function() {
                    return {
                        edit: true,
                        create: true
                    }
                }
            }
        },

        data() {
            return {
                title: "",
                search: "",
                loading: true,
                current_page: 1,
                last_page: 1,
                rows: []
            }
        },

        computed: {
            back() {
                return this.current_page !== 1;
            },
            forward() {
                return this.current_page !== this.last_page;
            }
        },

        created() {
            if (this.name) {
                this.title = this.name;
            } else {
                this.title = this.endpoint;
            }

            this.getTableData();
        },

        methods: {
            dynamicFilter(filter, value) {
                if (filter && filter in this.$options.filters) {
                    return this.$options.filters[filter](value);
                }

                return value;
            },

            deleteRow(row) {
                this.$http.delete(this.endpoint + '/' + row.id)
                    .then(() => {
                        let indexDeleted = this.rows.indexOf(row);
                        this.rows.splice(indexDeleted, 1);
                    });
            },

            move(page_number) {
                if (this.current_page === page_number || page_number < 1 || page_number > this.last_page) {
                    return;
                }

                this.loading = true;
                this.getTableData(page_number);
            },

            getTableData(page_number = 1) {
                this.$http.get(this.endpoint + `?page=${page_number}` )
                    .then(response => {
                        if (this.paginate) {
                            this.current_page = response.data.current_page;
                            this.last_page = response.data.last_page;
                            this.rows = response.data.data;
                        } else {
                            this.rows = response.data;
                        }

                        this.loading = false;
                    })
            },

            handleClick(id) {
                if (this.link_to_detail !== null) {
                    this.$router.push({ name: this.link_to_detail, params: { id: id }});
                }
            }
        }
    }
</script>