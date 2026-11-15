export default function RequestMessage({ status, message }) {
    if (status === 'loading') {
        return (
            <p className="py-6 text-center text-slate-500">
                Завантаження…
            </p>
        );
    }

    if (status === 'error') {
        return (
            <p className="py-6 text-center text-red-600">
                {message || 'Не вдалося завантажити дані.'}
            </p>
        );
    }

    if (status === 'empty') {
        return (
            <p className="py-6 text-center text-slate-500">
                {message || 'Даних поки немає.'}
            </p>
        );
    }

    return null;
}
