<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Planos
        $planoBasico = DB::table('planos')->insertGetId(['nome' => 'Básico', 'descricao' => 'Plano básico para sindicatos pequenos', 'valor_mensal' => 199.90, 'limite_usuarios' => 3, 'limite_associados' => 200, 'cms_habilitado' => false, 'relatorios_avancados' => false, 'portal_associado' => false, 'ativo' => true, 'created_at' => now(), 'updated_at' => now()]);
        $planoPro = DB::table('planos')->insertGetId(['nome' => 'Profissional', 'descricao' => 'Plano completo com todos os recursos', 'valor_mensal' => 499.90, 'limite_usuarios' => 10, 'limite_associados' => 2000, 'cms_habilitado' => true, 'relatorios_avancados' => true, 'portal_associado' => true, 'ativo' => true, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('planos')->insert(['nome' => 'Enterprise', 'descricao' => 'Plano ilimitado para grandes sindicatos', 'valor_mensal' => 999.90, 'limite_usuarios' => 50, 'limite_associados' => 10000, 'cms_habilitado' => true, 'relatorios_avancados' => true, 'portal_associado' => true, 'ativo' => true, 'created_at' => now(), 'updated_at' => now()]);

        // 2. Tenant
        $tenantId = DB::table('tenants')->insertGetId(['nome' => 'SEEBAM - Sindicato dos Bancários', 'slug' => 'seebam', 'cnpj' => '12.345.678/0001-90', 'email' => 'contato@seebam.org.br', 'telefone' => '(92) 3232-1234', 'endereco' => 'Rua dos Bancários, 100', 'cidade' => 'Manaus', 'estado' => 'AM', 'cep' => '69000-000', 'plano_id' => $planoPro, 'ativo' => true, 'created_at' => now(), 'updated_at' => now()]);

        // 3. Roles
        $roleSuperAdmin = DB::table('roles')->insertGetId(['nome' => 'Super Admin', 'slug' => 'super-admin', 'descricao' => 'Acesso total ao sistema', 'permissoes' => json_encode(['*']), 'created_at' => now(), 'updated_at' => now()]);
        $roleGestor = DB::table('roles')->insertGetId(['nome' => 'Gestor', 'slug' => 'gestor', 'descricao' => 'Gestão do sindicato', 'permissoes' => json_encode(['associados.*','dependentes.*','bancos.*','agencias.*','servicos.*','relatorios.*','cms.*']), 'created_at' => now(), 'updated_at' => now()]);
        $roleFinanceiro = DB::table('roles')->insertGetId(['nome' => 'Financeiro', 'slug' => 'financeiro', 'descricao' => 'Gestão financeira', 'permissoes' => json_encode(['mensalidades.*','pagamentos.*','relatorios.financeiro','relatorios.inadimplencia']), 'created_at' => now(), 'updated_at' => now()]);
        $roleAtendimento = DB::table('roles')->insertGetId(['nome' => 'Atendimento', 'slug' => 'atendimento', 'descricao' => 'Atendimento ao associado', 'permissoes' => json_encode(['associados.read','dependentes.*','servicos.*','conveniados.read']), 'created_at' => now(), 'updated_at' => now()]);
        $roleAssociado = DB::table('roles')->insertGetId(['nome' => 'Associado', 'slug' => 'associado', 'descricao' => 'Portal do associado', 'permissoes' => json_encode(['portal.*']), 'created_at' => now(), 'updated_at' => now()]);

        // 4. Users
        DB::table('users')->insert([
            ['name' => 'Super Admin', 'email' => 'admin@sindigestao.com.br', 'password' => Hash::make('admin123'), 'tenant_id' => null, 'role_id' => $roleSuperAdmin, 'level' => 9, 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Carlos Gestor', 'email' => 'gestor@seebam.org.br', 'password' => Hash::make('gestor123'), 'tenant_id' => $tenantId, 'role_id' => $roleGestor, 'level' => 1, 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ana Financeiro', 'email' => 'financeiro@seebam.org.br', 'password' => Hash::make('financeiro123'), 'tenant_id' => $tenantId, 'role_id' => $roleFinanceiro, 'level' => 0, 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Maria Atendimento', 'email' => 'atendimento@seebam.org.br', 'password' => Hash::make('atendimento123'), 'tenant_id' => $tenantId, 'role_id' => $roleAtendimento, 'level' => 0, 'ativo' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 5. Lookups
        $estados = ['AC'=>'Acre','AL'=>'Alagoas','AM'=>'Amazonas','AP'=>'Amapá','BA'=>'Bahia','CE'=>'Ceará','DF'=>'Distrito Federal','ES'=>'Espírito Santo','GO'=>'Goiás','MA'=>'Maranhão','MG'=>'Minas Gerais','MS'=>'Mato Grosso do Sul','MT'=>'Mato Grosso','PA'=>'Pará','PB'=>'Paraíba','PE'=>'Pernambuco','PI'=>'Piauí','PR'=>'Paraná','RJ'=>'Rio de Janeiro','RN'=>'Rio Grande do Norte','RO'=>'Rondônia','RR'=>'Roraima','RS'=>'Rio Grande do Sul','SC'=>'Santa Catarina','SE'=>'Sergipe','SP'=>'São Paulo','TO'=>'Tocantins'];
        foreach ($estados as $sigla => $nome) {
            DB::table('estados')->insert(['esta_descr_estado' => $nome, 'esta_sigla' => $sigla, 'created_at' => now(), 'updated_at' => now()]);
        }

        $amId = DB::table('estados')->where('esta_sigla', 'AM')->value('esta_cod_estado');
        $manausId = DB::table('municipios')->insertGetId(['esta_cod_estado' => $amId, 'muni_descr_municipio' => 'Manaus', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('municipios')->insert([
            ['esta_cod_estado' => $amId, 'muni_descr_municipio' => 'Parintins', 'created_at' => now(), 'updated_at' => now()],
            ['esta_cod_estado' => $amId, 'muni_descr_municipio' => 'Itacoatiara', 'created_at' => now(), 'updated_at' => now()],
        ]);

        foreach (['Solteiro(a)','Casado(a)','Divorciado(a)','Viúvo(a)','União Estável'] as $ec) {
            DB::table('estados_civis')->insert(['esci_descr_estado_civil' => $ec, 'created_at' => now(), 'updated_at' => now()]);
        }
        $ecCasado = DB::table('estados_civis')->where('esci_descr_estado_civil', 'Casado(a)')->value('esci_cod_estado_civil');
        $ecSolteiro = DB::table('estados_civis')->where('esci_descr_estado_civil', 'Solteiro(a)')->value('esci_cod_estado_civil');

        foreach (['Ensino Fundamental','Ensino Médio','Superior Incompleto','Superior Completo','Pós-Graduação','Mestrado','Doutorado'] as $e) {
            DB::table('escolaridades')->insert(['esco_descr_escolaridade' => $e, 'created_at' => now(), 'updated_at' => now()]);
        }
        $escSuperior = DB::table('escolaridades')->where('esco_descr_escolaridade', 'Superior Completo')->value('esco_cod_escolaridade');

        $parentescos = ['Cônjuge','Filho(a)','Pai','Mãe','Irmão(ã)','Neto(a)','Bisneto(a)','Afilhado(a)','Guarda Judicial'];
        foreach ($parentescos as $p) {
            DB::table('parentescos')->insert(['pare_descricao_parentesco' => $p, 'created_at' => now(), 'updated_at' => now()]);
        }

        foreach (['Escriturário','Caixa','Gerente de Conta','Gerente Geral','Supervisor','Analista','Técnico Bancário'] as $c) {
            DB::table('cargos')->insert(['carg_descr_cargo' => $c, 'created_at' => now(), 'updated_at' => now()]);
        }
        $cargoEscrit = DB::table('cargos')->where('carg_descr_cargo', 'Escriturário')->value('carg_cod_cargo');

        foreach (['Odontologia','Clínica Geral','Psicologia','Contabilidade','Oftalmologia','Ortopedia','Cardiologia','Laboratório'] as $esp) {
            DB::table('especialidades')->insert(['espe_descr_especialidade' => $esp, 'created_at' => now(), 'updated_at' => now()]);
        }

        $sitAtivo = DB::table('situacao_associado')->insertGetId(['sias_descr_situacao_associado' => 'Ativo', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('situacao_associado')->insert([
            ['sias_descr_situacao_associado' => 'Inativo', 'created_at' => now(), 'updated_at' => now()],
            ['sias_descr_situacao_associado' => 'Afastado', 'created_at' => now(), 'updated_at' => now()],
            ['sias_descr_situacao_associado' => 'Aposentado', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $tsDentista = DB::table('tipo_servicos')->insertGetId(['tser_descr_tipo_servico' => 'Dentista', 'created_at' => now(), 'updated_at' => now()]);
        $tsMedico = DB::table('tipo_servicos')->insertGetId(['tser_descr_tipo_servico' => 'Médico', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('tipo_servicos')->insert([
            ['tser_descr_tipo_servico' => 'Psicólogo', 'created_at' => now(), 'updated_at' => now()],
            ['tser_descr_tipo_servico' => 'Contador', 'created_at' => now(), 'updated_at' => now()],
            ['tser_descr_tipo_servico' => 'Convênio Externo', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $ssAberto = DB::table('situacao_servicos')->insertGetId(['sise_descr_situacao_servico' => 'Aberto', 'created_at' => now(), 'updated_at' => now()]);
        DB::table('situacao_servicos')->insert([
            ['sise_descr_situacao_servico' => 'Em Andamento', 'created_at' => now(), 'updated_at' => now()],
            ['sise_descr_situacao_servico' => 'Concluído', 'created_at' => now(), 'updated_at' => now()],
            ['sise_descr_situacao_servico' => 'Cancelado', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 6. Bancos e Agências
        $bancoBB = DB::table('bancos')->insertGetId(['banc_descricao_banco' => 'Banco do Brasil', 'banc_situacao_banco' => 'Ativo', 'tenant_id' => $tenantId, 'created_at' => now(), 'updated_at' => now()]);
        $bancoCEF = DB::table('bancos')->insertGetId(['banc_descricao_banco' => 'Caixa Econômica Federal', 'banc_situacao_banco' => 'Ativo', 'tenant_id' => $tenantId, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('bancos')->insert(['banc_descricao_banco' => 'Bradesco', 'banc_situacao_banco' => 'Ativo', 'tenant_id' => $tenantId, 'created_at' => now(), 'updated_at' => now()]);

        $agBB = DB::table('agencias')->insertGetId(['agnc_descr_agencia' => 'BB Centro', 'agnc_numero_agencia' => '3190', 'agnc_cod_municipio' => $manausId, 'banc_cod_banco' => $bancoBB, 'agnc_endereco_agencia' => 'Av. Eduardo Ribeiro, 475', 'agnc_situacao_agencia' => 'Ativa', 'tenant_id' => $tenantId, 'created_at' => now(), 'updated_at' => now()]);
        $agCEF = DB::table('agencias')->insertGetId(['agnc_descr_agencia' => 'CEF Adrianópolis', 'agnc_numero_agencia' => '0855', 'agnc_cod_municipio' => $manausId, 'banc_cod_banco' => $bancoCEF, 'agnc_endereco_agencia' => 'Av. Djalma Batista, 1661', 'agnc_situacao_agencia' => 'Ativa', 'tenant_id' => $tenantId, 'created_at' => now(), 'updated_at' => now()]);

        // 7. Associados (15 registros)
        $nomes = ['Maria Silva','João Santos','Ana Oliveira','Carlos Lima','Pedro Costa','Lucia Ferreira','Roberto Alves','Marcos Souza','Fernanda Pereira','Paulo Mendes','Sandra Rodrigues','André Nascimento','Patrícia Gomes','Ricardo Araújo','Juliana Barbosa'];
        $associadoIds = [];
        foreach ($nomes as $i => $nome) {
            $associadoIds[] = DB::table('associados')->insertGetId([
                'asso_nome_associado' => $nome, 'asso_data_nasc' => fake()->dateTimeBetween('-55 years', '-25 years')->format('Y-m-d'),
                'asso_sexo_associado' => $i % 2 === 0 ? 'F' : 'M', 'esci_cod_estado_civil' => $i < 8 ? $ecCasado : $ecSolteiro,
                'asso_nacionalidade_associado' => 'Brasileira', 'asso_mae_associado' => 'Mãe de ' . explode(' ', $nome)[0],
                'asso_pai_associado' => 'Pai de ' . explode(' ', $nome)[0], 'esco_cod_escolaridade' => $escSuperior,
                'asso_email_associado' => strtolower(str_replace(' ', '.', $nome)) . '@email.com',
                'asso_cpf_associado' => fake()->unique()->numerify('###.###.###-##'),
                'asso_logradouro_endereco' => 'Rua ' . fake()->streetName(), 'asso_numero_endereco' => (string) fake()->numberBetween(1, 999),
                'asso_bairro_endereco' => 'Centro', 'asso_cep_endereco' => '69000-' . str_pad($i * 10, 3, '0', STR_PAD_LEFT),
                'asso_cidade_endereco' => $manausId, 'asso_estado_endereco' => $amId,
                'asso_ativo_associado' => $i < 12, 'asso_sindicalista_associado' => $i < 3,
                'asso_data_inscricao' => fake()->dateTimeBetween('-5 years', '-1 month')->format('Y-m-d H:i:s'),
                'asso_telefone_1_associado' => '(92) 9' . fake()->numerify('####-####'),
                'tenant_id' => $tenantId, 'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        // 8. Dependentes
        $conjugeId = DB::table('parentescos')->where('pare_descricao_parentesco', 'Cônjuge')->value('pare_cod_parentesco');
        $filhoId = DB::table('parentescos')->where('pare_descricao_parentesco', 'Filho(a)')->value('pare_cod_parentesco');
        foreach (array_slice($associadoIds, 0, 8) as $assocId) {
            DB::table('dependentes')->insert([
                'depe_inscricao' => $assocId, 'depe_nome' => 'Cônjuge de Assoc. ' . $assocId, 'depe_sexo' => 'F',
                'depe_datanascimento' => fake()->dateTimeBetween('-50 years', '-25 years')->format('Y-m-d'),
                'pare_cod_parentesco' => $conjugeId, 'depe_datainscricao' => now(), 'depe_ativo' => true,
                'tenant_id' => $tenantId, 'created_at' => now(), 'updated_at' => now(),
            ]);
            DB::table('dependentes')->insert([
                'depe_inscricao' => $assocId, 'depe_nome' => 'Filho(a) de Assoc. ' . $assocId, 'depe_sexo' => 'M',
                'depe_datanascimento' => fake()->dateTimeBetween('-18 years', '-1 year')->format('Y-m-d'),
                'pare_cod_parentesco' => $filhoId, 'depe_datainscricao' => now(), 'depe_ativo' => true,
                'tenant_id' => $tenantId, 'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        // 9. Histórico Profissional
        foreach ($associadoIds as $assocId) {
            DB::table('associado_agencia')->insert([
                'asso_inscricao_associado' => $assocId, 'agnc_cod_agencia' => $assocId % 2 === 0 ? $agBB : $agCEF,
                'asag_matricula' => 10000 + $assocId, 'carg_cod_cargo' => $cargoEscrit,
                'asag_dt_admissao' => fake()->dateTimeBetween('-10 years', '-1 year')->format('Y-m-d H:i:s'),
                'sias_cod_situacao_associado' => $sitAtivo, 'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        // 10. Mensalidades (2025 e 2026)
        foreach ($associadoIds as $assocId) {
            for ($mes = 1; $mes <= 12; $mes++) {
                DB::table('mensalidades')->insert([
                    'asso_inscricao_associado' => $assocId, 'ano' => 2025, 'mes' => $mes, 'valor' => 90.00,
                    'status' => 'pago', 'data_pagamento' => "2025-{$mes}-10", 'data_vencimento' => "2025-{$mes}-10",
                    'tenant_id' => $tenantId, 'created_at' => now(), 'updated_at' => now(),
                ]);
            }
            for ($mes = 1; $mes <= 4; $mes++) {
                $status = ($assocId > $associadoIds[11] && $mes >= 2) ? 'atrasado' : (($mes <= 3) ? 'pago' : 'pendente');
                DB::table('mensalidades')->insert([
                    'asso_inscricao_associado' => $assocId, 'ano' => 2026, 'mes' => $mes, 'valor' => 95.00,
                    'status' => $status, 'data_pagamento' => $status === 'pago' ? "2026-{$mes}-10" : null,
                    'data_vencimento' => "2026-{$mes}-10", 'tenant_id' => $tenantId, 'created_at' => now(), 'updated_at' => now(),
                ]);
            }
        }

        // 11. Pagamentos
        foreach (array_slice($associadoIds, 0, 10) as $assocId) {
            DB::table('pagamentos')->insert([
                'asso_inscricao_associado' => $assocId, 'tipo' => 'mensalidade', 'valor' => 95.00,
                'data_pagamento' => '2026-03-10', 'forma_pagamento' => 'Desconto em folha',
                'tenant_id' => $tenantId, 'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        // 12. Conveniados
        $espOdonto = DB::table('especialidades')->where('espe_descr_especialidade', 'Odontologia')->value('espe_cod_especialidade');
        $espLab = DB::table('especialidades')->where('espe_descr_especialidade', 'Laboratório')->value('espe_cod_especialidade');
        DB::table('conveniados')->insert([
            ['espe_cod_especialidade' => $espOdonto, 'conv_nome_conveniado' => 'OdontoPlus Manaus', 'conv_endereco_conveniado' => 'Av. Djalma Batista, 500', 'conv_telefone_1_conveniado' => '(92) 3234-5678', 'conv_dt_vigencia' => '2027-12-31', 'conv_ativo' => true, 'tenant_id' => $tenantId, 'created_at' => now(), 'updated_at' => now()],
            ['espe_cod_especialidade' => $espLab, 'conv_nome_conveniado' => 'LabAnalisa', 'conv_endereco_conveniado' => 'Rua Paraíba, 200', 'conv_telefone_1_conveniado' => '(92) 3233-9876', 'conv_dt_vigencia' => '2027-06-30', 'conv_ativo' => true, 'tenant_id' => $tenantId, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 13. Elegibilidade (Motor de Benefícios)
        DB::table('servico_elegibilidade')->insert([
            ['tser_tipo_servico' => $tsDentista, 'pare_cod_parentesco' => null, 'elegivel' => true, 'tipo_cobranca' => 'gratuito', 'valor' => null, 'percentual_desconto' => null, 'tenant_id' => $tenantId, 'created_at' => now(), 'updated_at' => now()],
            ['tser_tipo_servico' => $tsDentista, 'pare_cod_parentesco' => $conjugeId, 'elegivel' => true, 'tipo_cobranca' => 'percentual_desconto', 'valor' => null, 'percentual_desconto' => 50.00, 'tenant_id' => $tenantId, 'created_at' => now(), 'updated_at' => now()],
            ['tser_tipo_servico' => $tsDentista, 'pare_cod_parentesco' => $filhoId, 'elegivel' => true, 'tipo_cobranca' => 'valor_fixo', 'valor' => 30.00, 'percentual_desconto' => null, 'tenant_id' => $tenantId, 'created_at' => now(), 'updated_at' => now()],
            ['tser_tipo_servico' => $tsMedico, 'pare_cod_parentesco' => null, 'elegivel' => true, 'tipo_cobranca' => 'gratuito', 'valor' => null, 'percentual_desconto' => null, 'tenant_id' => $tenantId, 'created_at' => now(), 'updated_at' => now()],
            ['tser_tipo_servico' => $tsMedico, 'pare_cod_parentesco' => $conjugeId, 'elegivel' => true, 'tipo_cobranca' => 'valor_fixo', 'valor' => 50.00, 'percentual_desconto' => null, 'tenant_id' => $tenantId, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 14. Configurações
        DB::table('configuracoes')->insert([
            ['tenant_id' => $tenantId, 'chave' => 'valor_mensalidade', 'valor' => '95.00', 'grupo' => 'financeiro', 'created_at' => now(), 'updated_at' => now()],
            ['tenant_id' => $tenantId, 'chave' => 'dia_vencimento', 'valor' => '10', 'grupo' => 'financeiro', 'created_at' => now(), 'updated_at' => now()],
            ['tenant_id' => $tenantId, 'chave' => 'nome_sindicato', 'valor' => 'SEEBAM', 'grupo' => 'geral', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
