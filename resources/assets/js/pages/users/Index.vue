<template>
    <section>
        <data-table
            endpoint="users"
            :columns="columns"
            :actions="actions"
            link_to_detail="users.show"
        ></data-table>
    </section>
</template>

<script>
    import CreateUser from './Create';
    import DataTable from '../../components/DataTable';

    export default {
        components: {
            CreateUser,
            DataTable
        },

        data() {
            return {
                loading: true,
                actions: {
                    edit: false,
                    create: true
                },
                columns: [
                    {
                        name: 'Name',
                        data_name: 'name'
                    },
                    {
                        name: 'Email',
                        data_name: 'email'
                    },
                    {
                        name: 'Debts',
                        data_name: 'debt',
                        filter: 'formatNumber'
                    },
                    {
                        name: 'Last login',
                        data_name: 'last_login'
                    },
                    {
                        name: 'Date',
                        data_name: 'created_at'
                    }
                ]
            }
        }
    }
</script>