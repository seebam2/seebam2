// Mock data seeders for each user profile dashboard

export type UserRole = "super_admin" | "gestor" | "financeiro" | "atendimento" | "associado";

export interface UserProfile {
  name: string;
  email: string;
  role: UserRole;
  roleLabel: string;
  initials: string;
  sindicato?: string;
}

export const userProfiles: Record<UserRole, UserProfile> = {
  super_admin: {
    name: "Ricardo Mendes",
    email: "ricardo@sindigestao.com",
    role: "super_admin",
    roleLabel: "Super Admin",
    initials: "RM",
    sindicato: "Plataforma SindiGestão",
  },
  gestor: {
    name: "Fernanda Oliveira",
    email: "fernanda@seebam.org.br",
    role: "gestor",
    roleLabel: "Gestor",
    initials: "FO",
    sindicato: "SEEBAM",
  },
  financeiro: {
    name: "Paulo Nascimento",
    email: "paulo@seebam.org.br",
    role: "financeiro",
    roleLabel: "Financeiro",
    initials: "PN",
    sindicato: "SEEBAM",
  },
  atendimento: {
    name: "Carla Ribeiro",
    email: "carla@seebam.org.br",
    role: "atendimento",
    roleLabel: "Atendimento",
    initials: "CR",
    sindicato: "SEEBAM",
  },
  associado: {
    name: "José Almeida",
    email: "jose.almeida@email.com",
    role: "associado",
    roleLabel: "Associado",
    initials: "JA",
    sindicato: "SEEBAM",
  },
};

// ── Super Admin Seeders ──
export const superAdminData = {
  kpis: [
    { title: "Sindicatos Ativos", value: "14", change: "+2 este trimestre", changeType: "positive" as const },
    { title: "Total de Associados", value: "18.430", change: "+340 este mês", changeType: "positive" as const },
    { title: "Receita Total MRR", value: "R$ 42.800", change: "+8,3% vs mês anterior", changeType: "positive" as const },
    { title: "Uptime Plataforma", value: "99,97%", change: "últimos 30 dias", changeType: "neutral" as const },
  ],
  tenants: [
    { id: 1, name: "SEEBAM", associados: 2847, plano: "Enterprise", status: "Ativo", mrr: "R$ 4.200" },
    { id: 2, name: "SINDIBANCÁRIOS-SP", associados: 5120, plano: "Enterprise", status: "Ativo", mrr: "R$ 6.800" },
    { id: 3, name: "SINDICOMERCIÁRIOS-RJ", associados: 3200, plano: "Profissional", status: "Ativo", mrr: "R$ 3.500" },
    { id: 4, name: "SINDSAÚDE-MG", associados: 1890, plano: "Profissional", status: "Ativo", mrr: "R$ 2.800" },
    { id: 5, name: "SINDMETAL-BA", associados: 980, plano: "Básico", status: "Trial", mrr: "R$ 0" },
  ],
  revenueChart: [
    { name: "Jan", valor: 35200 },
    { name: "Fev", valor: 36400 },
    { name: "Mar", valor: 38100 },
    { name: "Abr", valor: 39800 },
    { name: "Mai", valor: 41200 },
    { name: "Jun", valor: 42800 },
  ],
  planoDistribuicao: [
    { name: "Enterprise", value: 5, color: "hsl(220, 65%, 48%)" },
    { name: "Profissional", value: 6, color: "hsl(250, 65%, 55%)" },
    { name: "Básico", value: 2, color: "hsl(142, 71%, 45%)" },
    { name: "Trial", value: 1, color: "hsl(38, 92%, 50%)" },
  ],
};

// ── Gestor Seeders ──
export const gestorData = {
  kpis: [
    { title: "Associados Ativos", value: "2.847", change: "+12 este mês", changeType: "positive" as const },
    { title: "Novos Associados", value: "28", change: "+40% vs mês anterior", changeType: "positive" as const },
    { title: "Convênios Ativos", value: "18", change: "2 novos este mês", changeType: "positive" as const },
    { title: "Taxa Retenção", value: "96,2%", change: "+0,5% vs trimestre", changeType: "positive" as const },
  ],
  associadosPorStatus: [
    { name: "Ativos", value: 2847, color: "hsl(142, 71%, 45%)" },
    { name: "Afastados", value: 198, color: "hsl(38, 92%, 50%)" },
    { name: "Inativos", value: 342, color: "hsl(0, 84%, 60%)" },
  ],
  crescimentoMensal: [
    { name: "Jan", novos: 18, saidas: 5 },
    { name: "Fev", novos: 22, saidas: 8 },
    { name: "Mar", novos: 15, saidas: 3 },
    { name: "Abr", novos: 30, saidas: 6 },
    { name: "Mai", novos: 25, saidas: 4 },
    { name: "Jun", novos: 28, saidas: 7 },
  ],
  ultimosAssociados: [
    { id: 1, name: "Maria Clara Santos", agencia: "Ag. Centro 0142", data: "02/04/2026" },
    { id: 2, name: "Fernando Gomes", agencia: "Ag. Sul 0287", data: "01/04/2026" },
    { id: 3, name: "Beatriz Lima", agencia: "Ag. Norte 0053", data: "31/03/2026" },
    { id: 4, name: "André Costa", agencia: "Ag. Oeste 0198", data: "30/03/2026" },
    { id: 5, name: "Juliana Martins", agencia: "Ag. Centro 0142", data: "29/03/2026" },
  ],
};

// ── Financeiro Seeders ──
export const financeiroData = {
  kpis: [
    { title: "Receita Mensal", value: "R$ 52.400", change: "+5,2% vs mês anterior", changeType: "positive" as const },
    { title: "Inadimplência", value: "R$ 12.870", change: "43 associados", changeType: "negative" as const },
    { title: "A Receber", value: "R$ 256.140", change: "2.847 mensalidades", changeType: "neutral" as const },
    { title: "Despesas Serviços", value: "R$ 18.300", change: "-3% vs mês anterior", changeType: "positive" as const },
  ],
  receitaChart: [
    { name: "Jan", receita: 45200, despesa: 19800 },
    { name: "Fev", receita: 48100, despesa: 20100 },
    { name: "Mar", receita: 47800, despesa: 18900 },
    { name: "Abr", receita: 51200, despesa: 19200 },
    { name: "Mai", receita: 49800, despesa: 18700 },
    { name: "Jun", receita: 52400, despesa: 18300 },
  ],
  inadimplentes: [
    { id: 1, name: "Roberto Alves", meses: 3, valor: "R$ 270,00", agencia: "Ag. Centro 0142" },
    { id: 2, name: "Lucia Ferreira", meses: 2, valor: "R$ 180,00", agencia: "Ag. Sul 0287" },
    { id: 3, name: "Marcos Souza", meses: 4, valor: "R$ 360,00", agencia: "Ag. Norte 0053" },
    { id: 4, name: "Tereza Nunes", meses: 1, valor: "R$ 90,00", agencia: "Ag. Oeste 0198" },
    { id: 5, name: "Sergio Barbosa", meses: 5, valor: "R$ 450,00", agencia: "Ag. Centro 0142" },
  ],
  pagamentosRecentes: [
    { id: 1, name: "Ana Oliveira", tipo: "Mensalidade", valor: "R$ 90,00", data: "04/04/2026", status: "Confirmado" },
    { id: 2, name: "Carlos Lima", tipo: "Serviço Dentista", valor: "R$ 45,00", data: "04/04/2026", status: "Confirmado" },
    { id: 3, name: "Pedro Costa", tipo: "Mensalidade", valor: "R$ 90,00", data: "03/04/2026", status: "Confirmado" },
    { id: 4, name: "Maria Silva", tipo: "Convênio Lab", valor: "R$ 120,00", data: "03/04/2026", status: "Pendente" },
  ],
};

// ── Atendimento Seeders ──
export const atendimentoData = {
  kpis: [
    { title: "Atendimentos Hoje", value: "12", change: "4 em andamento", changeType: "neutral" as const },
    { title: "Agendamentos", value: "38", change: "próximos 7 dias", changeType: "neutral" as const },
    { title: "Satisfação", value: "4,7/5", change: "+0,2 vs mês anterior", changeType: "positive" as const },
    { title: "Tempo Médio", value: "18 min", change: "-3 min vs média", changeType: "positive" as const },
  ],
  agendamentosHoje: [
    { id: 1, name: "Maria Silva", servico: "Dentista", horario: "09:00", status: "Concluído" },
    { id: 2, name: "João Santos", servico: "Psicólogo", horario: "09:30", status: "Concluído" },
    { id: 3, name: "Ana Oliveira", servico: "Médico", horario: "10:00", status: "Em atendimento" },
    { id: 4, name: "Pedro Costa", servico: "Contador", horario: "10:30", status: "Aguardando" },
    { id: 5, name: "Lucia Ferreira", servico: "Dentista", horario: "11:00", status: "Aguardando" },
    { id: 6, name: "Carlos Lima", servico: "Médico", horario: "11:30", status: "Aguardando" },
  ],
  servicosDemanda: [
    { name: "Dentista", value: 340, color: "hsl(220, 65%, 48%)" },
    { name: "Médico", value: 280, color: "hsl(250, 65%, 55%)" },
    { name: "Psicólogo", value: 180, color: "hsl(142, 71%, 45%)" },
    { name: "Contador", value: 120, color: "hsl(38, 92%, 50%)" },
  ],
  atendimentosSemana: [
    { name: "Seg", total: 18 },
    { name: "Ter", total: 22 },
    { name: "Qua", total: 15 },
    { name: "Qui", total: 20 },
    { name: "Sex", total: 24 },
  ],
};

// ── Associado Seeders ──
export const associadoData = {
  perfil: {
    nome: "José Almeida",
    cpf: "***.***.***-47",
    matricula: "2847",
    agencia: "Ag. Centro 0142 - Banco do Brasil",
    cargo: "Escriturário",
    sindicalizadoDesde: "15/03/2018",
    status: "Ativo",
  },
  mensalidades: [
    { mes: "Janeiro", ano: 2026, valor: "R$ 90,00", status: "Pago", data: "05/01/2026" },
    { mes: "Fevereiro", ano: 2026, valor: "R$ 90,00", status: "Pago", data: "05/02/2026" },
    { mes: "Março", ano: 2026, valor: "R$ 90,00", status: "Pago", data: "04/03/2026" },
    { mes: "Abril", ano: 2026, valor: "R$ 90,00", status: "Pendente", data: "-" },
  ],
  dependentes: [
    { nome: "Ana Almeida", parentesco: "Cônjuge", nascimento: "22/07/1990", status: "Ativo" },
    { nome: "Lucas Almeida", parentesco: "Filho", nascimento: "14/02/2015", status: "Ativo" },
  ],
  servicosDisponiveis: [
    { nome: "Dentista", tipo: "Interno", beneficio: "Gratuito para titular", proximo: "12/04/2026" },
    { nome: "Médico Clínico", tipo: "Interno", beneficio: "Gratuito para titular", proximo: "Agendar" },
    { nome: "Psicólogo", tipo: "Interno", beneficio: "50% desconto", proximo: "Agendar" },
    { nome: "Lab. São Lucas", tipo: "Convênio", beneficio: "30% desconto", proximo: "-" },
    { nome: "Clínica Saúde+", tipo: "Convênio", beneficio: "20% desconto", proximo: "-" },
  ],
  ultimosAtendimentos: [
    { data: "15/03/2026", servico: "Dentista", profissional: "Dr. Marcos", status: "Concluído" },
    { data: "02/02/2026", servico: "Médico", profissional: "Dra. Carla", status: "Concluído" },
    { data: "10/12/2025", servico: "Contador", profissional: "Sr. Paulo", status: "Concluído" },
  ],
};
