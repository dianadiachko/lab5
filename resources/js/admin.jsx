import { createRoot } from 'react-dom/client';

import Dashboard from './admin/Dashboard.jsx';
import ProductsTable from './admin/ProductsTable.jsx';
import CategoriesTable from './admin/CategoriesTable.jsx';

const screens = {
    overview: Dashboard,
    products: ProductsTable,
    categories: CategoriesTable,
};

const container = document.getElementById('admin-content');

if (container) {
    const Screen = screens[container.dataset.screen];

    if (Screen) {
        createRoot(container).render(<Screen />);
    }
}
