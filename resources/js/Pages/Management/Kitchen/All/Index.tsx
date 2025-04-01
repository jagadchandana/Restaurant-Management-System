import ConfirmButton from '@/Components/ConfirmButton';
import { PrimaryLink } from '@/Components/PrimaryButton';
import MasterTable, { TableBody, TableTd } from '@/Components/tables/masterTable';
import KitchenAuthenticatedLayout from '@/Layouts/KitchenAuthenticatedLayout';
import { PencilIcon } from '@heroicons/react/20/solid';
import { Head } from '@inertiajs/react';

export default function Index({orders, filters}: any) {
    const tableColumns = [
        {
            label: "",
            sortField: "",
            sortable: false,
        },
        {
            label: "Queue Order",
            sortField: "queue_order",
            sortable: false,
        },
        {
            label: "Order ID",
            sortField: "order_number",
            sortable: true,
        },

        {
            label: "Total Price",
            sortField: "price",
            sortable: false,
        },
        {
            label: "Status",
            sortField: "status",
            sortable: true,
        },
        {
            label: "Kitchen Send At",
            sortField: "",
            sortable: false,
        },
        {
            label: "Created AT",
            sortField: "created_at",
            sortable: true,
        },

    ];
    const search = {
        placeholder: "Search Orders...",
    }
    return (
        <KitchenAuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Kitchen
                </h2>
            }
        >
            <Head title="Kitchen" />
            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="p-2 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <MasterTable
                            tableColumns={tableColumns}
                            url={"#"}
                            search={search}
                            filters={filters}
                            links={orders?.meta?.links}
                        >
                            {orders?.data?.map((order: any) => (
                                <TableBody
                                    buttons={
                                        <>
                                            <PrimaryLink
                                                className="!py-2"
                                                href={route("kitchen.edit", {
                                                    id: order.id
                                                })}
                                            >
                                                <PencilIcon className="w-5 h-5 mr-4" />
                                                {"View Order"}
                                            </PrimaryLink>
                                        </>

                                    }
                                    key={order.id}
                                >
                                    <TableTd>{order.queue_order}</TableTd>
                                    <TableTd>{order.order_number}</TableTd>
                                    <TableTd>{order.concessions_total}</TableTd>
                                    <TableTd>{order.status}</TableTd>
                                    <TableTd>{order.to_kitchen_human}</TableTd>
                                    <TableTd>{order.created_at_human}</TableTd>
                                </TableBody>
                            ))}
                        </MasterTable>
                    </div>
                </div>
            </div>
        </KitchenAuthenticatedLayout>
    );
};

