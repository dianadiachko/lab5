import { useEffect, useState } from 'react';
import { requestJson } from './api.js';
import RequestMessage from './RequestMessage.jsx';

export default function Dashboard() {
    const [productsCount, setProductsCount] = useState(0);
    const [categoriesCount, setCategoriesCount] = useState(0);
    const [status, setStatus] = useState('loading');
    const [error, setError] = useState('');

    useEffect(() => {
        const controller = new AbortController();

        async function loadData() {
            try {
                const [products, categories] = await Promise.all([
                    requestJson('/api/products', controller.signal),
                    requestJson('/api/categories', controller.signal),
                ]);

                if (!controller.signal.aborted) {
                    setProductsCount(products.data.length);
                    setCategoriesCount(categories.data.length);
                    setStatus('success');
                }
            } catch (err) {
                if (!controller.signal.aborted) {
                    setError(err.message);
                    setStatus('error');
                }
            }
        }

        loadData();

        return () => controller.abort();
    }, []);

    return (
        <div>
            {status === 'loading' && (
                <RequestMessage status="loading" />
            )}

            {status === 'error' && (
                <RequestMessage status="error" message={error} />
            )}

            {status === 'success' && (
                <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div className="rounded-xl bg-white p-6 shadow-sm">
                        <p className="text-sm text-slate-500">
                            Усього позицій
                        </p>
                        <p className="mt-3 text-3xl font-bold text-slate-800">
                            {productsCount}
                        </p>
                    </div>

                    <div className="rounded-xl bg-white p-6 shadow-sm">
                        <p className="text-sm text-slate-500">
                            Категорій
                        </p>
                        <p className="mt-3 text-3xl font-bold text-slate-800">
                            {categoriesCount}
                        </p>
                    </div>
                </div>
            )}
        </div>
    );
}
