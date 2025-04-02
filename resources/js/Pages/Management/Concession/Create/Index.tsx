import InputError from "@/Components/InputError";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, router, useForm } from "@inertiajs/react";
import { FormEventHandler } from "react";

export default function Index({ }) {
    const { data, setData, errors, post } = useForm<{
        name: string;
        price: string;
        description: string;
        image: File | string;
    }>({
        name: '',
        price: '',
        description: '',
        image: '',
    });
console.log(errors,'errors');
    const submit: FormEventHandler = (e) => {
        e.preventDefault();
       post(route("concessions.store"));
    };
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
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            Create Concession
                        </div>
                        <form className="p-6 text-gray-900" onSubmit={submit}>

                            <div className="mb-4">
                                <label
                                    htmlFor="name"
                                    className="block mb-2 text-sm font-bold text-gray-700"
                                >
                                    Name
                                </label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    className="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                    placeholder="Enter name"
                                    value={data.name}
                                    onChange={(e) => setData('name', e.target.value)}

                                />
                                <InputError message={errors.name} />
                            </div>
                            <div className="mb-4">
                                <label
                                    htmlFor="price"
                                    className="block mb-2 text-sm font-bold text-gray-700"
                                >
                                    Price
                                </label>
                                <input
                                    type="text"
                                    id="price"
                                    name="price"
                                    className="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                    placeholder="Enter price"
                                    value={data.price}
                                    onChange={(e) => setData('price', e.target.value)}

                                />
                                <InputError message={errors.price} />
                            </div>


                            <div className="mb-4">
                                <label
                                    htmlFor="description"
                                    className="block mb-2 text-sm font-bold text-gray-700"
                                >
                                    Description
                                </label>
                                <textarea
                                    id="description"
                                    name="description"
                                    rows={4}
                                    className="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                    placeholder="Enter description"
                                    value={data.description}
                                    onChange={(e) => setData('description', e.target.value)}
                                ></textarea>
                                <InputError message={errors.description} />
                            </div>

                            <div className="mb-4">
                                <label
                                    htmlFor="image"
                                    className="block mb-2 text-sm font-bold text-gray-700"
                                >
                                    Image
                                </label>
                                <input
                                    type="file"
                                    id="image"
                                    name="image"
                                    accept="image/*"
                                    onChange={(e) => {
                                        if (e.target.files && e.target.files[0]) {
                                            const file = e.target.files[0];
                                            setData('image', file);
                                        }
                                    }}
                                    className="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                />
                                <InputError message={errors.image} />
                            </div>
                            <button
                                className="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline"
                            >
                                Create Concession
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
};
