import { useEffect, useState } from 'react';
import { requestJson } from './api.js';
import RequestMessage from './RequestMessage.jsx';

export default function CategoriesTable() {
    const [categories, setCategories] = useState([]);
    const [status, setStatus] = useState('loading');
    const [error, setError] = useState('');

    useEffect(() => {
        const controller = new AbortController();

        async function loadCategories() {
            try {
                const response = await requestJson(
                    '/api/categories',
                    controller.signal
                );

                if (!controller.signal.aborted) {
                    setCategories(response.data);
                    setStatus(response.data.length ? 'success' : 'empty');
                }
            } catch (err) {
                if (!controller.signal.aborted) {
                    setError(err.message);
                    setStatus('error');
                }
            }
        }

        loadCategories();

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
                                <th className="px-4 py-3">Slug</th>
                            </tr>
                        </thead>

                        <tbody>
                            {categories.map((category) => (
                                <tr
                                    key={category.id}
                                    className="border-b border-slate-100"
                                >
                                    <td className="px-4 py-3">
                                        {category.id}
                                    </td>
                                    <td className="px-4 py-3 font-medium">
                                        {category.name}
                                    </td>
                                    <td className="px-4 py-3">
                                        {category.slug}
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
