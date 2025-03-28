import { BarsArrowUpIcon, MagnifyingGlassCircleIcon, XMarkIcon } from '@heroicons/react/20/solid';
import { forwardRef, useEffect, useImperativeHandle, useRef, InputHTMLAttributes } from 'react';

export default forwardRef(function SearchInput(
    {
        className = "",
        isFocused = false,
        resetSearch,
        ...props
    }: InputHTMLAttributes<HTMLInputElement> & {
        isFocused?: boolean;
        resetSearch: any;
    },
    ref
) {
    const localRef = useRef<HTMLInputElement>(null);

    useImperativeHandle(ref, () => ({
        focus: () => localRef.current?.focus(),
    }));

    useEffect(() => {
        if (isFocused) {
            localRef.current?.focus();
        }
    }, []);

    return (
        <div className="mt-2 flex rounded-md shadow-sm">
            <div className="relative flex flex-grow items-stretch focus-within:z-10">
                <div className="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <MagnifyingGlassCircleIcon
                        className="h-5 w-5 text-gray-400"
                        aria-hidden="true"
                    />
                </div>
                <input
                    {...props}
                    ref={localRef}
                    className="block w-full rounded-none rounded-l-md border-0 py-1.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                />
            </div>
            <button
                type="button"
                onClick={() => resetSearch()}
                className="relative -ml-px inline-flex items-center gap-x-1.5 rounded-r-md px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
            >
                <XMarkIcon
                    className="-ml-0.5 h-5 w-5 text-gray-400"
                    aria-hidden="true"
                />
            </button>
        </div>
    );
});
