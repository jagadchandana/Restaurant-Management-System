import KitchenAuthenticatedLayout from "@/Layouts/KitchenAuthenticatedLayout";
import { Head, router } from "@inertiajs/react";

export default function Index({order}:any) {
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
                            <h3 className="text-lg font-bold">Order Items</h3>
                            <ul>
                                {order?.concessions?.map((item:any, index:number) => (
                                    <li key={index} className="mb-4">
                                        <div className="flex items-center">
                                            <img
                                                src={item.image_url}
                                                alt={item.name}
                                                className="w-16 h-16 mr-4 rounded"
                                            />
                                            <div>
                                                <h4 className="font-semibold text-md">{item.name}</h4>
                                                <p className="text-sm text-gray-600">{item.description}</p>
                                                <p className="text-sm font-bold text-gray-800">${item.price}</p>
                                            </div>
                                        </div>
                                    </li>
                                ))}
                            </ul>
                            <h3 className="mt-6 text-lg font-bold">Order Details</h3>
                            <div className="mt-4">
                                <p className="text-sm font-semibold">Order Number: {order?.order_number}</p>
                                <p className="text-sm font-semibold">Total Price: ${order?.concessions_total}</p>
                                <p className="text-sm font-semibold">Status: {order?.status}</p>
                                <p className="text-sm font-semibold">Created At: {order?.created_at_human}</p>
                                <p className="text-sm font-semibold">Kitchen Send At: {order?.to_kitchen_human}</p>
                            </div>
                            <div className="mt-4">
                                <button
                                    onClick={() => router.put(route('kitchen.update', order.id))}
                                    className="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700"
                                >
                                    complete Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </KitchenAuthenticatedLayout>
    );
};
