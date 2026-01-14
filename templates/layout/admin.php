<?php
/**
 * Layout administrativo do Digital Menu
 *
 * @var \App\View\AppView $this
 */

$adminTitle = 'Digital Menu - Admin';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $adminTitle ?>
        <?= $this->fetch('title') ? ' | ' . $this->fetch('title') : '' ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <?= $this->Html->css(['normalize.min']) ?>

    <style>
        :root {
            --primary: #1e3a5f;
            --primary-light: #2c5282;
            --accent: #ed8936;
            --accent-hover: #dd6b20;
            --bg-dark: #0f172a;
            --bg-sidebar: #1e293b;
            --bg-content: #f8fafc;
            --text-light: #f1f5f9;
            --text-muted: #94a3b8;
            --text-dark: #1e293b;
            --border: #334155;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --card-bg: #ffffff;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg-content);
            color: var(--text-dark);
            min-height: 100vh;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .admin-sidebar {
            width: 260px;
            background: linear-gradient(180deg, var(--bg-dark) 0%, var(--bg-sidebar) 100%);
            color: var(--text-light);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 100;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-logo {
            width: 40px;
            height: 40px;
            background: var(--accent);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .sidebar-brand {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-light);
        }

        .sidebar-brand span {
            color: var(--accent);
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-section {
            padding: 0.5rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            margin-top: 1rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .nav-link:hover {
            color: var(--text-light);
            background: rgba(255, 255, 255, 0.05);
        }

        .nav-link.active {
            color: var(--accent);
            background: rgba(237, 137, 54, 0.1);
            border-left-color: var(--accent);
        }

        .nav-link.logout-link {
            color: var(--danger);
            margin-top: 1rem;
        }

        .nav-link.logout-link:hover {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }

        .nav-link svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        /* Main Content */
        .admin-main {
            flex: 1;
            margin-left: 260px;
            display: flex;
            flex-direction: column;
        }

        /* Top Bar */
        .admin-topbar {
            background: var(--card-bg);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: var(--bg-content);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .user-menu:hover {
            background: var(--primary-light);
            color: white;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        /* Content Area */
        .admin-content {
            padding: 2rem;
            flex: 1;
        }

        /* Flash Messages */
        .message {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .message.success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid var(--success);
            color: var(--success);
        }

        .message.error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid var(--danger);
            color: var(--danger);
        }

        .message.warning {
            background: rgba(245, 158, 11, 0.1);
            border: 1px solid var(--warning);
            color: var(--warning);
        }

        /* Cards */
        .card {
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: var(--shadow);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .card-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.875rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-light);
        }

        .btn-accent {
            background: var(--accent);
            color: white;
        }

        .btn-accent:hover {
            background: var(--accent-hover);
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        /* Tables */
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .table th {
            font-weight: 600;
            color: var(--text-muted);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .table tbody tr:hover {
            background: var(--bg-content);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon.blue { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
        .stat-icon.green { background: rgba(16, 185, 129, 0.1); color: #10b981; }
        .stat-icon.orange { background: rgba(237, 137, 54, 0.1); color: #ed8936; }
        .stat-icon.purple { background: rgba(139, 92, 246, 0.1); color: #8b5cf6; }

        .stat-info h3 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .stat-info p {
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        /* Forms */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text-dark);
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(30, 58, 95, 0.1);
        }

        /* Small Buttons */
        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
        }

        /* Actions Column */
        .actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        /* Paginator */
        .card-footer {
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }

        .paginator {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .pagination {
            display: flex;
            gap: 0.25rem;
            list-style: none;
            flex-wrap: wrap;
        }

        .pagination li a,
        .pagination li span {
            display: inline-block;
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.875rem;
            color: var(--text-dark);
            background: var(--bg-content);
            transition: all 0.2s ease;
        }

        .pagination li a:hover {
            background: var(--primary);
            color: white;
        }

        .pagination li.active span {
            background: var(--primary);
            color: white;
        }

        .pagination li.disabled span {
            color: var(--text-muted);
            cursor: not-allowed;
        }

        .pagination-info {
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        /* Links in tables */
        .table a {
            color: var(--primary);
            text-decoration: none;
        }

        .table a:hover {
            color: var(--accent);
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .admin-sidebar.open {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
            }
        }
    </style>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">🍽</div>
                <div class="sidebar-brand">Digital <span>Menu</span></div>
            </div>

            <?php
            $currentController = $this->request->getParam('controller');
            $currentAction = $this->request->getParam('action');
            ?>
            <nav class="sidebar-nav">
                <div class="nav-section">Principal</div>
                <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Dashboard', 'action' => 'index']) ?>" class="nav-link <?= $currentController === 'Dashboard' ? 'active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>

                <div class="nav-section">Gerenciamento</div>
                <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Restaurants', 'action' => 'index']) ?>" class="nav-link <?= $currentController === 'Restaurants' ? 'active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Restaurantes
                </a>
                <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Categories', 'action' => 'index']) ?>" class="nav-link <?= $currentController === 'Categories' ? 'active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Categorias
                </a>
                <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Items', 'action' => 'index']) ?>" class="nav-link <?= $currentController === 'Items' ? 'active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Produtos
                </a>
                <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'OpeningHours', 'action' => 'index']) ?>" class="nav-link <?= $currentController === 'OpeningHours' ? 'active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Horários
                </a>
                <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Banners', 'action' => 'index']) ?>" class="nav-link <?= $currentController === 'Banners' ? 'active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Banners
                </a>
                <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'FooterInfo', 'action' => 'index']) ?>" class="nav-link <?= $currentController === 'FooterInfo' ? 'active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Rodapé
                </a>

                <div class="nav-section">Loja & Pagamentos</div>
                <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'ShopSettings', 'action' => 'index']) ?>" class="nav-link <?= $currentController === 'ShopSettings' ? 'active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Config. da Loja
                </a>
                <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'PaymentMethods', 'action' => 'index']) ?>" class="nav-link <?= $currentController === 'PaymentMethods' ? 'active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    Pagamentos
                </a>

                <div class="nav-section">Configurações</div>
                <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'AdminUsers', 'action' => 'index']) ?>" class="nav-link <?= $currentController === 'AdminUsers' ? 'active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Usuários Admin
                </a>
                <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'AccessLogs', 'action' => 'index']) ?>" class="nav-link <?= $currentController === 'AccessLogs' ? 'active' : '' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Logs de Acesso
                </a>

                <div class="nav-section">Sistema</div>
                <a href="<?= $this->Url->build('/') ?>" class="nav-link" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    Ver Site
                </a>
                <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Auth', 'action' => 'logout']) ?>" class="nav-link logout-link">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Sair
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <!-- Top Bar -->
            <header class="admin-topbar">
                <h1 class="topbar-title"><?= $this->fetch('title') ?: 'Dashboard' ?></h1>
                <div class="topbar-actions">
                    <?php if (isset($currentUser)): ?>
                    <div class="user-menu">
                        <div class="user-avatar"><?= strtoupper(substr($currentUser->username ?? 'A', 0, 1)) ?></div>
                        <span><?= h($currentUser->username ?? 'Admin') ?></span>
                    </div>
                    <?php else: ?>
                    <div class="user-menu">
                        <div class="user-avatar">A</div>
                        <span>Admin</span>
                    </div>
                    <?php endif; ?>
                </div>
            </header>

            <!-- Content -->
            <div class="admin-content">
                <?= $this->Flash->render() ?>
                <?= $this->fetch('content') ?>
            </div>
        </main>
    </div>

    <?= $this->fetch('script') ?>
</body>
</html>
