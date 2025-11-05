<?php
// @file: modules/abandonedcartrecovery/abandonedcartrecovery.php

if (!defined('_PS_VERSION_')) {
    exit;
}

// Definición del módulo
class AbandonedCartRecovery extends Module
{
    public function __construct()
    {
        $this->name = 'abandonedcartrecovery';
        $this->tab = 'emailing';
        $this->version = '1.0.0';
        $this->author = 'Tu Nombre o Empresa';
        $this->need_instance = 0; // No es necesario instanciarlo en cada página
        $this->ps_versions_compliancy = ['min' => '1.7.8.10', 'max' => _PS_VERSION_];
        $this->bootstrap = true; // Activa el uso de Bootstrap en el backoffice

        parent::__construct();

        $this->displayName = $this->l('Abandoned Cart Recovery');
        $this->description = $this->l('Send automated emails to recover abandoned carts, with optional personalized coupons.');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
    }

    /**
     * Instala el módulo y crea las tablas necesarias
     */
    public function install()
    {
        if (!parent::install()) {
            return false;
        }

        // Registrar hooks que usaremos en fases posteriores
        if (!$this->registerHook('actionCartSave') ||
            !$this->registerHook('actionCartUpdateQuantity') ||
            !$this->registerHook('actionObjectOrderAdd') ||
            !$this->registerHook('displayBackOfficeHeader')) {
            return false;
        }

        // Ejecutar script de instalación SQL
        include(dirname(__FILE__) . '/sql/install.php');
        if (!installTables()) {
            return false;
        }

        return true;
    }

    /**
     * Desinstala el módulo y elimina las tablas
     */
    public function uninstall()
    {
        // Ejecutar script de desinstalación SQL
        include(dirname(__FILE__) . '/sql/uninstall.php');
        if (!uninstallTables()) {
            return false;
        }

        return parent::uninstall();
    }

    /**
     * Contenido del panel de administración (lo implementaremos en fases posteriores)
     */
    public function getContent()
    {
        $output = '';

        // Aquí irá la lógica para manejar formularios de configuración y mostrar la UI del backoffice
        // Por ahora, solo mostramos un mensaje de confirmación.

        $output .= $this->displayConfirmation($this->l('Configuration updated successfully.'));

        return $output . $this->renderForm();
    }

    private function renderForm()
    {
        // Formulario básico para mostrar que estamos en la Fase 1
        return '<div class="panel"><h3>'.$this->l('Module Configuration').'</h3><p>'.$this->l('This is the basic structure. Configuration will be implemented in later phases.').'</p></div>';
    }
}