import { AppLayout } from "@/components/AppLayout";
import { StatCard } from "@/components/StatCard";
import { Card } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { Users, DollarSign, HeartPulse, AlertTriangle } from "lucide-react";
import {
  BarChart,
  Bar,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  ResponsiveContainer,
  PieChart,
  Pie,
  Cell,
} from "recharts";

const monthlyData = [
  { name: "Jan", valor: 45200 },
  { name: "Fev", valor: 48100 },
  { name: "Mar", valor: 47800 },
  { name: "Abr", valor: 51200 },
  { name: "Mai", valor: 49800 },
  { name: "Jun", valor: 52400 },
];

const serviceData = [
  { name: "Dentista", value: 340, color: "hsl(220, 65%, 48%)" },
  { name: "Médico", value: 280, color: "hsl(250, 65%, 55%)" },
  { name: "Psicólogo", value: 180, color: "hsl(142, 71%, 45%)" },
  { name: "Contador", value: 120, color: "hsl(38, 92%, 50%)" },
];

const recentActivity = [
  { id: 1, action: "Novo associado cadastrado", name: "Maria Silva", time: "há 5 min" },
  { id: 2, action: "Pagamento confirmado", name: "João Santos", time: "há 12 min" },
  { id: 3, action: "Consulta agendada", name: "Ana Oliveira", time: "há 30 min" },
  { id: 4, action: "Mensalidade paga", name: "Carlos Lima", time: "há 1h" },
  { id: 5, action: "Novo dependente", name: "Pedro Costa", time: "há 2h" },
];

const inadimplentes = [
  { id: 1, name: "Roberto Alves", meses: 3, valor: "R$ 270,00" },
  { id: 2, name: "Lucia Ferreira", meses: 2, valor: "R$ 180,00" },
  { id: 3, name: "Marcos Souza", meses: 4, valor: "R$ 360,00" },
];

export default function Dashboard() {
  return (
    <AppLayout title="Dashboard">
      <div className="space-y-6 max-w-7xl">
        {/* KPI Cards */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <StatCard
            title="Associados Ativos"
            value="2.847"
            change="+12 este mês"
            changeType="positive"
            icon={<Users className="h-5 w-5" />}
          />
          <StatCard
            title="Receita Mensal"
            value="R$ 52.400"
            change="+5,2% vs mês anterior"
            changeType="positive"
            icon={<DollarSign className="h-5 w-5" />}
          />
          <StatCard
            title="Atendimentos"
            value="184"
            change="este mês"
            changeType="neutral"
            icon={<HeartPulse className="h-5 w-5" />}
          />
          <StatCard
            title="Inadimplentes"
            value="43"
            change="1,5% da base"
            changeType="negative"
            icon={<AlertTriangle className="h-5 w-5" />}
          />
        </div>

        {/* Charts Row */}
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-4">
          <Card className="col-span-1 lg:col-span-2 p-5">
            <h3 className="text-sm font-semibold text-card-foreground mb-4">Arrecadação Mensal</h3>
            <ResponsiveContainer width="100%" height={260}>
              <BarChart data={monthlyData}>
                <CartesianGrid strokeDasharray="3 3" stroke="hsl(220, 13%, 91%)" />
                <XAxis dataKey="name" tick={{ fontSize: 12 }} stroke="hsl(220, 10%, 46%)" />
                <YAxis tick={{ fontSize: 12 }} stroke="hsl(220, 10%, 46%)" />
                <Tooltip
                  formatter={(value: number) => [`R$ ${value.toLocaleString("pt-BR")}`, "Valor"]}
                  contentStyle={{ borderRadius: 8, border: "1px solid hsl(220, 13%, 91%)", fontSize: 12 }}
                />
                <Bar dataKey="valor" fill="hsl(220, 65%, 48%)" radius={[4, 4, 0, 0]} />
              </BarChart>
            </ResponsiveContainer>
          </Card>

          <Card className="p-5">
            <h3 className="text-sm font-semibold text-card-foreground mb-4">Serviços Utilizados</h3>
            <ResponsiveContainer width="100%" height={200}>
              <PieChart>
                <Pie
                  data={serviceData}
                  cx="50%"
                  cy="50%"
                  innerRadius={50}
                  outerRadius={80}
                  dataKey="value"
                  stroke="none"
                >
                  {serviceData.map((entry, i) => (
                    <Cell key={i} fill={entry.color} />
                  ))}
                </Pie>
                <Tooltip contentStyle={{ borderRadius: 8, fontSize: 12 }} />
              </PieChart>
            </ResponsiveContainer>
            <div className="grid grid-cols-2 gap-2 mt-2">
              {serviceData.map((s) => (
                <div key={s.name} className="flex items-center gap-2">
                  <div className="h-2 w-2 rounded-full" style={{ backgroundColor: s.color }} />
                  <span className="text-xs text-muted-foreground">{s.name}</span>
                </div>
              ))}
            </div>
          </Card>
        </div>

        {/* Bottom Row */}
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-4">
          <Card className="p-5">
            <h3 className="text-sm font-semibold text-card-foreground mb-4">Atividade Recente</h3>
            <div className="space-y-3">
              {recentActivity.map((item) => (
                <div key={item.id} className="flex items-center justify-between py-2 border-b border-border last:border-0">
                  <div>
                    <p className="text-sm text-card-foreground">{item.action}</p>
                    <p className="text-xs text-muted-foreground">{item.name}</p>
                  </div>
                  <span className="text-xs text-muted-foreground whitespace-nowrap">{item.time}</span>
                </div>
              ))}
            </div>
          </Card>

          <Card className="p-5">
            <div className="flex items-center justify-between mb-4">
              <h3 className="text-sm font-semibold text-card-foreground">Inadimplência</h3>
              <Badge variant="destructive" className="text-[10px]">Atenção</Badge>
            </div>
            <div className="space-y-3">
              {inadimplentes.map((item) => (
                <div key={item.id} className="flex items-center justify-between py-2 border-b border-border last:border-0">
                  <div>
                    <p className="text-sm text-card-foreground">{item.name}</p>
                    <p className="text-xs text-muted-foreground">{item.meses} meses em atraso</p>
                  </div>
                  <span className="text-sm font-medium text-destructive">{item.valor}</span>
                </div>
              ))}
            </div>
          </Card>
        </div>
      </div>
    </AppLayout>
  );
}
