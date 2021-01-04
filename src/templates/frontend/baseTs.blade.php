<?=

"
import { Vue } from \"vue-class-component\";
import Swal from \"sweetalert2\";

export default class Charges extends Vue {
    Swal!: typeof Swal

    options: object = {}
    charges: object[] = []
    events: object[] = []

    created() {
        this.setData()
        this.options = {
            data: this.charges,
            // columns: [
            //     // { data: 'id', title: 'id' },
            //     { data: 'oks.name', title: 'oks' },
            //     { data: 'offence.name', title: 'offence' },
            //     { data: 'geolocation.address', title: 'address' },
            //     { data: 'created_at', title: 'created_at' },
            // ]
            columns: [
                // { data: 'id', title: 'id' },
                { data: 'oks.name' },
                { data: 'offence.name' },
                { data: 'geolocation.address' },
                { data: 'created_at' },
                // { data: 'oks.name'},
                {
                    data: 'id',
                    render: function (data: string, type: string, row: any) {

                        let html = `<div class=\"btn-group\" role=\"group\" aria-label=\"Action Button Group\">`;
                        html += `<button type=\"button\" class=\"btn btn-primary btn-sm approve\"><i class=\"fas fa-check\" data-placement=\"top\" title=\"Approve\" data-action=\"approve\" data-id=\"\${data}\"></i></button>`;
                        html += `<button type=\"button\" class=\"btn btn-danger btn-sm reject\"><i class=\"fas fa-ban\" data-placement=\"top\" title=\"Reject\" data-action=\"reject\" data-id=\"\${data}\"></i></button>`;
                        html += `<button type=\"button\" class=\"btn btn-light btn-sm view\"><i class=\"far fa-eye\" data-placement=\"top\" title=\"View\" data-id=\"\${data}\"></i></button>`;
                        html += `<button type=\"button\" class=\"btn btn-light btn-sm edit\"><i class=\"fas fa-edit\" data-placement=\"top\" title=\"Edit\" data-id=\"\${data}\"></i></button>`;
                        html += `<button type=\"button\" class=\"btn btn-danger btn-sm delete\"><i class=\"far fa-trash-alt\" data-placement=\"top\" title=\"Delete\" data-id=\"\${data}\"></i></button>`;
                        html += `</div>`;

                        return html;
                    }

                },
            ]
        }
        this.registerEvents();

    }

    registerEvents() {
        this.events = [
            {
                selector: '.approve',
                trigger: 'click',
                action: (jquery: any) => this.approveData(jquery.target.dataset.id)
            },
            {
                selector: '.reject',
                trigger: 'click',
                action: (jquery: any) => this.rejectData(jquery.target.dataset.id)
            },
            {
                selector: '.view',
                trigger: 'click',
                action: (jquery: any) => this.viewData(jquery.target.dataset.id)
            },
            {
                selector: '.edit',
                trigger: 'click',
                action: (jquery: any) => this.editData(jquery.target.dataset.id)
            },
            {
                selector: '.delete',
                trigger: 'click',
                action: (jquery: any) => this.deleteData(jquery.target.dataset.id)
            },
            {
                selector: '.view',
                trigger: 'click',
                action: (jquery: any) => this.viewData(jquery.target.dataset.id)
            }
        ]
    }

    approveData(value: any) {
        this.Swal.fire({
            title: 'Are you sure?',
            text: \"You won't be able to revert this!\",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Proceed it!'
        }).then((result: any) => {
            if (result.isConfirmed) {
                //somecode route
                this.\$router.replace('/case/department');
            }
        })
    }

    rejectData(value: any) {
        this.Swal.fire({
            title: 'Are you sure?',
            text: \"You won't be able to revert this!\",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Proceed it!'
        }).then((result) => {
            if (result.isConfirmed) {
                //somecode route
            }
        })

    }

    viewData(value: any) {
        this.\$router.replace('/charges/view');
    }

    editData(value: any) {
        this.\$router.replace('/charges/edit');
    }

    deleteData(value: any) {
        this.Swal.fire({
            title: 'Are you sure?',
            text: \"You won't be able to revert this!\",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Proceed it!'
        }).then((result) => {
            if (result.isConfirmed) {
                //somecode route
                // this.\$router.replace('/case/department');


            }
        })
    }


    setData() {
        this.charges = [
            {
                id: 1,
                oks: {
                    name: 'Kertas Pertuduhan',
                    address: 'Kertas Pertuduhan',
                },
                offence: {
                    act: 'AKTA 132',
                    section: 'SEKSYEN 12 (2)',
                    name: 'Timbus tanah',
                    description: 'Timbus tanah',
                },
                geolocation: {
                    address: 'LOT 3 MUKIM 12',
                    lat: '0.12973',
                    long: '0.12973',
                },
                created_at: '03 JUN 2020',
            },
            {
                id: 1,
                oks: {
                    name: 'Kertas Pertuduhan',
                    address: 'LOT 3 PENANG',
                },
                offence: {
                    act: 'AKTA 132',
                    section: 'SEKSYEN 12 (2)',
                    name: 'Timbus tanah',
                    description: 'Timbus tanah',
                },
                geolocation: {
                    address: 'LOT 3 MUKIM 12',
                    lat: '0.12973',
                    long: '0.12973',
                },
                created_at: '03 JUN 2020',
            },

        ]
    }
}

"
?>