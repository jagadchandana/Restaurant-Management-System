import InputError from "@/Components/InputError";
import SelectMultiInput from "@/Components/SelectMultiInput";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, router, useForm } from "@inertiajs/react";
import { FormEventHandler } from "react";

export default function Index({ concessions }: any) {
    const { data, setData, errors, post } = useForm({
        to_kitchen: '',
        concession_ids: [{}],
    });
    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        router.post(route("orders.store"), data);
    };
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Orders
                </h2>

            }
        >
            <Head title="Orders" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            All Orders
                        </div>
                        <form className="p-6 text-gray-900">

                            <div className="mb-4">
                                <label
                                    htmlFor="name"
                                    className="block mb-2 text-sm font-bold text-gray-700"
                                >
                                    Concessions
                                </label>
                                <SelectMultiInput
                                    options={concessions}
                                    selectedOption={concessions?.filter((obj: { value: number; }) => {
                                        return data.concession_ids?.includes(obj?.value);
                                    })}
                                    setData={(e: any) => setData('concession_ids', e)}
                                />

                                <InputError message={errors.concession_ids} />
                            </div>
                            <div className="mb-4">
                                <label
                                    htmlFor="name"
                                    className="block mb-2 text-sm font-bold text-gray-700"
                                >
                                    To Kitchen
                                </label>
                                <input
                                    type="dateTime-local"
                                    id="to_kitchen"
                                    name="to_kitchen"
                                    className="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                                    placeholder="Enter to kitchen"
                                    value={data.to_kitchen}
                                    onChange={(e) => setData('to_kitchen', e.target.value)}

                                />
                                <InputError message={errors.to_kitchen} />
                            </div>

                            <button
                                type="button"
                                onClick={submit}
                                className="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline"
                            >
                                Create Order
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
};
