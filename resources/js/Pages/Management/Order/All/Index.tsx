import ConfirmButton from '@/Components/ConfirmButton';
import { PrimaryLink } from '@/Components/PrimaryButton';
import MasterTable, { TableBody, TableTd } from '@/Components/tables/masterTable';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { PencilIcon } from '@heroicons/react/20/solid';
import { Head } from '@inertiajs/react';

export default function Index({ concessions, filters }: any) {

    const tableColumns = [
        {
            label: "",
            sortField: "",
            sortable: false,
        },
        {
            label: "ID",
            sortField: "id",
            sortable: true,
        },
        {
            label: "Name",
            sortField: "name",
            sortable: true,
        },
        {
            label: "Price",
            sortField: "price",
            sortable: false,
        },
        {
            label: "Created AT",
            sortField: "created_at",
            sortable: true,
        },

    ];

    const createLink = {
        url: route("concessions.create"),
        label: "Create Concession",
    }

    const importLink = {
        url: "#",
        label: "Import Roles",
    }

    const exportLink = {
        url: "#",
        label: "Export Roles",
    }


    const search = {
        placeholder: "Search Roles...",
    }


    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Concession
                </h2>

            }
        >
            <Head title="Concession" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="p-2 overflow-hidden bg-white shadow-sm sm:rounded-lg">

                        <MasterTable
                            tableColumns={tableColumns}
                            url={"#"}
                            createLink={createLink}
                            importLink={importLink}
                            exportLink={exportLink}
                            search={search}
                            filters={filters}
                            links={concessions?.meta?.links}
                        >
                            {concessions?.data?.map((concession: any) => (
                                <TableBody
                                    buttons={
                                        <>
                                            <PrimaryLink
                                                className="!py-2"
                                                href={route("concessions.edit", {
                                                    id: concession.id
                                                })}
                                            >
                                                <PencilIcon className="w-5 h-5 mr-4" />
                                                {"Edit"}
                                            </PrimaryLink>
                                            <ConfirmButton
                                                className="!py-2"
                                                url={route("concessions.destroy", {
                                                    id: concession.id
                                                })}
                                                label="Delete"
                                            />
                                        </>

                                    }
                                    key={concession.id}
                                >
                                    <TableTd>{concession.id}</TableTd>
                                    <TableTd>{concession.name}</TableTd>
                                    <TableTd>{concession.price}</TableTd>
                                    <TableTd>{concession.created_at_human}</TableTd>
                                </TableBody>
                            ))}
                        </MasterTable>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
};

