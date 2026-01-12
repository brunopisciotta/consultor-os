<?php
session_start();

// Carrega o Autoload do Composer
require '../vendor/autoload.php';

use App\Core\Router;
use App\Controllers\SiteController;
use App\Controllers\AuthController;
use App\Controllers\DashController; 
use App\Controllers\SimulatorController;
use App\Controllers\LeadController;
use App\Controllers\ProposalController;
use App\Controllers\NotificationController;
use App\Controllers\ToolsController;
use App\Controllers\SettingsController;
use App\Controllers\ManualController;
use App\Controllers\ReportController;

// Instancia o Router
$router = new Router();

// ROTA DA LANDING PAGE (Pública)
$router->get('/', [SiteController::class, 'index']);

// ROTA DE LOGIN
$router->get('/login', [AuthController::class, 'login']); 
$router->post('/login', [AuthController::class, 'auth']); 

// Dashboard
$router->get('/dashboard', [DashController::class, 'index']);

// Simulador
$router->get('/simulador', [SimulatorController::class, 'index']);
$router->post('/simulador/save', [SimulatorController::class, 'save']);
$router->post('/simulador/delete', [SimulatorController::class, 'delete']);

$router->get('/leads', [LeadController::class, 'index']); 
$router->post('/leads', [LeadController::class, 'index']); 

// Gerar PDF
$router->get('/proposal/pdf', [ProposalController::class, 'generate']);
// Ferramentas PDF
$router->get('/ferramentas/investidor/pdf', [ToolsController::class, 'investorPdf']);
$router->get('/ferramentas/lances/pdf', [ToolsController::class, 'bidPdf']);
$router->get('/relatorios/pdf', [ReportController::class, 'exportPdf']);

// Detalhes do Lead
$router->get('/leads/details', [LeadController::class, 'details']);

$router->get('/logout', [AuthController::class, 'logout']);

// ROTAS DE API (Notificações)
$router->get('/api/notifications', [NotificationController::class, 'list']);
$router->post('/api/notifications/read', [NotificationController::class, 'read']);

$router->post('/api/lead/register', [SiteController::class, 'registerLead']);

// NOVAS ROTAS
$router->post('/leads/update', [LeadController::class, 'update']); 
$router->get('/leads/delete', [LeadController::class, 'delete']); 

// NOVAS FERRAMENTAS
$router->get('/ferramentas/lances', [ToolsController::class, 'bidAnalyst']);
$router->get('/ferramentas/investidor', [ToolsController::class, 'roiCalculator']);

// Config
$router->get('/configuracoes', [SettingsController::class, 'index']);
$router->post('/configuracoes/update', [SettingsController::class, 'update']);

// Manual do Sistema
$router->get('/manual', [ManualController::class, 'index']);

// RELATÓRIOS E PERFORMANCE (NOVO)
$router->get('/relatorios', [\App\Controllers\ReportController::class, 'index']);
$router->post('/relatorios/save', [\App\Controllers\ReportController::class, 'save']);
$router->get('/relatorios/export', [\App\Controllers\ReportController::class, 'export']);

// Executa o sistema
$router->run();