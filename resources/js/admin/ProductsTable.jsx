import { useEffect, useState } from 'react';
import { requestJson } from './api.js';
import RequestMessage from './RequestMessage.jsx';

export default function ProductsTable() {
    const [products, setProducts] = useState([]);
    const [status, setStatus] = useState('loading');
    const [error, setError] = useState('');

    useEffect(() => {
        const controller = new AbortController();

        async function loadProducts() {
            try {
                const response = await requestJson(
                    '/api/products',
                    controller.signal
                );

                if (!controller.signal.aborted) {
                    setProducts(response.data);
                    setStatus(response.data.length ? 'success' : 'empty');
                }
            } catch (err) {
                if (!controller.signal.aborted) {
                    setError(err.message);
                    setStatus('error');
                }
            }
        }

        loadProducts();

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

            {status === 'empty' && (
                <RequestMessage status="empty" />
            )}

            {status === 'success' && (
                <div className="overflow-x-auto">
                    <table className="w-full text-left text-sm">
                        <thead className="bg-slate-50 text-slate-600">
                            <tr>
                                <th className="px-4 py-3">ID</th>
                                <th className="px-4 py-3">Назва</th>
                                <th className="px-4 py-3">Категорія</th>
                                <th className="px-4 py-3">Операція</th>
                                <th className="px-4 py-3">Ціна</th>
                            </tr>
                        </thead>

                        <tbody>
                            {products.map((product) => (
                                <tr
                                    key={product.id}
                                    className="border-b border-slate-100"
                                >
                                    <td className="px-4 py-3">
                                        {product.id}
                                    </td>
                                    <td className="px-4 py-3 font-medium">
                                        {product.title}
                                    </td>
                                    <td className="px-4 py-3">
                                        {product.category}
                                    </td>
                                    <td className="px-4 py-3">
                                        {product.operation}
                                    </td>
                                    <td className="px-4 py-3 whitespace-nowrap">
                                        {Number(product.price).toLocaleString('uk-UA')} {product.currency}
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            )}
        </div>
    );
}
