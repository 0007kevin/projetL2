<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bank</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-dark: #0f172a;
            --secondary-dark: #1e293b;
            --accent-blue: #3b82f6;
            --light-text: #f8fafc;
            --light-gray: #e2e8f0;
        }

        body {
            background-color: #f1f5f9;
            color: #1e293b;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Navigation */
        #sidebar {
            background: var(--primary-dark);
            min-height: 100vh;
            width: 280px;
            transition: all 0.3s;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-item {
            color: var(--light-text);
            padding: 0.75rem 1.5rem;
            margin: 0.25rem 1rem;
            border-radius: 8px;
            transition: all 0.2s;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .menu-item:hover, .menu-item.active {
            background-color: var(--accent-blue);
            color: white;
        }

        .menu-item i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        /* Contenu principal */
        .main-content {
            margin-left: 280px;
            padding: 2rem;
            min-height: 100vh;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        /* Cartes */
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
            border: none;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-card .icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .stat-card .icon.clients {
            background-color: rgba(59, 130, 246, 0.1);
            color: var(--accent-blue);
        }

        .stat-card .icon.transfers {
            background-color: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .stat-card .icon.loans {
            background-color: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }

        .stat-card .icon.revenue {
            background-color: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        /* Activités récentes */
        .activity-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .activity-item {
            padding: 1rem 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-badge {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }

        /* Responsive */
        @media (max-width: 992px) {
            #sidebar {
                width: 100%;
                min-height: auto;
                position: fixed;
                z-index: 1000;
            }
            .main-content {
                margin-left: 0;
                padding-top: 6rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav id="sidebar" class="position-fixed">
        <div class="sidebar-header">
            <h4 class="text-white mb-0">
                <i class="fas fa-university me-2"></i>
                My Bank
            </h4>
        </div>

        <div class="sidebar-menu">
            <a href="#" class="menu-item active">
                <i class="fas fa-home"></i>
                <span>Tableau de bord</span>
            </a>
            
            <a href="client.php" class="menu-item">
                <i class="fas fa-users"></i>
                <span>Gestion Clients</span>
            </a>
            
            <a href="virement.php" class="menu-item">
                <i class="fas fa-exchange-alt"></i>
                <span>Virements</span>
            </a>
            
            <a href="pret.php" class="menu-item">
                <i class="fas fa-hand-holding-usd"></i>
                <span>Prêts</span>
            </a>
            
            <a href="rendre.php" class="menu-item">
                <i class="fas fa-credit-card"></i>
                <span>Remboursements</span>
            </a>
        </div>
    </nav>

    <!-- Contenu principal -->
    <div class="main-content">
        <div class="dashboard-header">
            <h2 class="fw-bold">Tableau de bord</h2>
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-bell text-muted fs-5"></i>
                </div>
                
            </div>
        </div>

        <!-- Cartes statistiques -->
        <div class="row g-4 mb-4">
            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="icon clients">
                        <i class="fas fa-users fs-4"></i>
                    </div>
                    <h5 class="mb-1">1,248</h5>
                    <p class="text-muted mb-2">Clients actifs</p>
                    <small class="text-success">
                        <i class="fas fa-arrow-up me-1"></i>
                        5.2% ce mois
                    </small>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="icon transfers">
                        <i class="fas fa-exchange-alt fs-4"></i>
                    </div>
                    <h5 class="mb-1">Ar342K</h5>
                    <p class="text-muted mb-2">Virements</p>
                    <small class="text-success">
                        <i class="fas fa-arrow-up me-1"></i>
                        12.7% cette semaine
                    </small>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="icon loans">
                        <i class="fas fa-hand-holding-usd fs-4"></i>
                    </div>
                    <h5 class="mb-1">Ar1.8M</h5>
                    <p class="text-muted mb-2">Prêts en cours</p>
                    <small class="text-danger">
                        <i class="fas fa-arrow-down me-1"></i>
                        2.3% ce trimestre
                    </small>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="icon revenue">
                        <i class="fas fa-chart-line fs-4"></i>
                    </div>
                    <h5 class="mb-1">Ar89K</h5>
                    <p class="text-muted mb-2">Revenus mensuels</p>
                    <small class="text-success">
                        <i class="fas fa-arrow-up me-1"></i>
                        8.1% ce mois
                    </small>
                </div>
            </div>
        </div>

        <!-- Deuxième ligne -->
        <div class="row g-4">
            <!-- Activités récentes -->
            <div class="col-lg-8">
                <div class="activity-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Activités récentes</h5>
                        <a href="#" class="text-primary">Voir tout</a>
                    </div>

                    <div class="activity-item d-flex">
                        <div class="activity-badge bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Virement effectué</h6>
                            <p class="text-muted mb-0">RATOVOMANANA Dylan → ANDRIANILANA Bryan</p>
                            <small class="text-muted">Ar1,200 - 10:45 </small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-primary bg-opacity-10 text-primary">Complété</span>
                        </div>
                    </div>

                    <div class="activity-item d-flex">
                        <div class="activity-badge bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Nouveau prêt</h6>
                            <p class="text-muted mb-0">RANDRIAMANANA Kevin</p>
                            <small class="text-muted">Ar15,000 - Hier</small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-warning bg-opacity-10 text-warning">En attente</span>
                        </div>
                    </div>

                    <div class="activity-item d-flex">
                        <div class="activity-badge bg-success bg-opacity-10 text-success">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Nouveau client</h6>
                            <p class="text-muted mb-0">RANDRIANARISON Nisaie</p>
                            <small class="text-muted">Hier</small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success bg-opacity-10 text-success">Complété</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="col-lg-4">
                <div class="activity-card">
                    <h5 class="mb-3">Actions rapides</h5>
                    
                    <a href="client.php" class="btn btn-primary w-100 mb-3 py-2 d-flex align-items-center">
                    <i class="fas fa-users me-2"></i>
                       voir client
                       </a>

                    <a href="ajout/ajoutvir.php" class="btn btn-outline-primary w-100 mb-3 py-2 d-flex align-items-center">
                        <i class="fas fa-exchange-alt me-2"></i>
                        Nouveau virement
                    </a>
                    
                    <a href="ajout/ajoutpret.php" class="btn btn-outline-primary w-100 mb-3 py-2 d-flex align-items-center">
                        <i class="fas fa-file-invoice-dollar me-2"></i>
                        Créer un prêt
                    </a>

                    <a href="pdf.php" class="btn btn-outline-primary w-100 mb-3 py-2 d-flex align-items-center">
                        <i class="fas fa-file-pdf me-2"></i>
                        Générer pdf
                    </a>
                    
                   
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animation simple pour les cartes
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.stat-card');
            
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>