import KitchenAuthenticatedLayout from '@/Layouts/KitchenAuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function Index({}) {
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
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 bg-white border-b border-gray-200">
                            Kitchen Management
                        </div>
                    </div>
                </div>
            </div>
        </KitchenAuthenticatedLayout>
    );
};

