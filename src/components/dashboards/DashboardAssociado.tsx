import { Card } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { Button } from "@/components/ui/button";
import { User, CreditCard, HeartPulse, Users, Calendar } from "lucide-react";
import { associadoData } from "@/data/seeders";

export function DashboardAssociado() {
  const d = associadoData;

  return (
    <div className="space-y-6 max-w-5xl">
      {/* Welcome */}
      <div className="flex items-center gap-4">
        <div className="flex h-14 w-14 items-center justify-center rounded-full bg-primary/10">
          <User className="h-7 w-7 text-primary" />
        </div>
        <div>
          <h2 className="text-xl font-semibold text-foreground">Olá, {d.perfil.nome}!</h2>
          <p className="text-sm text-muted-foreground">Matrícula {d.perfil.matricula} • {d.perfil.agencia}</p>
        </div>
        <Badge className="ml-auto">{d.perfil.status}</Badge>
      </div>

      {/* Quick info */}
      <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <Card className="p-4 flex items-center gap-3">
          <CreditCard className="h-5 w-5 text-primary" />
          <div>
            <p className="text-xs text-muted-foreground">Mensalidade</p>
            <p className="text-sm font-semibold text-foreground">R$ 90,00/mês</p>
          </div>
        </Card>
        <Card className="p-4 flex items-center gap-3">
          <Users className="h-5 w-5 text-primary" />
          <div>
            <p className="text-xs text-muted-foreground">Dependentes</p>
            <p className="text-sm font-semibold text-foreground">{d.dependentes.length} cadastrados</p>
          </div>
        </Card>
        <Card className="p-4 flex items-center gap-3">
          <Calendar className="h-5 w-5 text-primary" />
          <div>
            <p className="text-xs text-muted-foreground">Sindicalizado desde</p>
            <p className="text-sm font-semibold text-foreground">{d.perfil.sindicalizadoDesde}</p>
          </div>
        </Card>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-2 gap-4">
        {/* Mensalidades */}
        <Card className="p-5">
          <div className="flex items-center justify-between mb-4">
            <h3 className="text-sm font-semibold text-card-foreground">Mensalidades 2026</h3>
            <CreditCard className="h-4 w-4 text-muted-foreground" />
          </div>
          <div className="space-y-3">
            {d.mensalidades.map((m) => (
              <div key={m.mes} className="flex items-center justify-between py-2 border-b border-border last:border-0">
                <div>
                  <p className="text-sm text-card-foreground">{m.mes}/{m.ano}</p>
                  <p className="text-xs text-muted-foreground">{m.data !== "-" ? `Pago em ${m.data}` : "Vencimento pendente"}</p>
                </div>
                <div className="text-right flex items-center gap-2">
                  <span className="text-sm text-card-foreground">{m.valor}</span>
                  <Badge variant={m.status === "Pago" ? "default" : "secondary"}>{m.status}</Badge>
                </div>
              </div>
            ))}
          </div>
        </Card>

        {/* Dependentes */}
        <Card className="p-5">
          <div className="flex items-center justify-between mb-4">
            <h3 className="text-sm font-semibold text-card-foreground">Meus Dependentes</h3>
            <Users className="h-4 w-4 text-muted-foreground" />
          </div>
          <div className="space-y-3">
            {d.dependentes.map((dep) => (
              <div key={dep.nome} className="flex items-center justify-between py-2 border-b border-border last:border-0">
                <div>
                  <p className="text-sm text-card-foreground font-medium">{dep.nome}</p>
                  <p className="text-xs text-muted-foreground">{dep.parentesco} • Nasc. {dep.nascimento}</p>
                </div>
                <Badge variant="outline">{dep.status}</Badge>
              </div>
            ))}
          </div>
        </Card>
      </div>

      {/* Serviços */}
      <Card className="p-5">
        <div className="flex items-center justify-between mb-4">
          <h3 className="text-sm font-semibold text-card-foreground">Serviços Disponíveis</h3>
          <HeartPulse className="h-4 w-4 text-muted-foreground" />
        </div>
        <div className="overflow-x-auto">
          <table className="w-full text-sm">
            <thead>
              <tr className="border-b text-left text-muted-foreground">
                <th className="pb-3 font-medium">Serviço</th>
                <th className="pb-3 font-medium">Tipo</th>
                <th className="pb-3 font-medium">Benefício</th>
                <th className="pb-3 font-medium">Próximo</th>
                <th className="pb-3 font-medium"></th>
              </tr>
            </thead>
            <tbody>
              {d.servicosDisponiveis.map((s) => (
                <tr key={s.nome} className="border-b border-border last:border-0">
                  <td className="py-3 font-medium text-card-foreground">{s.nome}</td>
                  <td className="py-3"><Badge variant="outline">{s.tipo}</Badge></td>
                  <td className="py-3 text-muted-foreground">{s.beneficio}</td>
                  <td className="py-3 text-muted-foreground">{s.proximo}</td>
                  <td className="py-3">
                    {s.proximo === "Agendar" && (
                      <Button size="sm" variant="outline">Agendar</Button>
                    )}
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </Card>

      {/* Últimos atendimentos */}
      <Card className="p-5">
        <h3 className="text-sm font-semibold text-card-foreground mb-4">Últimos Atendimentos</h3>
        <div className="space-y-3">
          {d.ultimosAtendimentos.map((a, i) => (
            <div key={i} className="flex items-center justify-between py-2 border-b border-border last:border-0">
              <div>
                <p className="text-sm text-card-foreground">{a.servico} — {a.profissional}</p>
                <p className="text-xs text-muted-foreground">{a.data}</p>
              </div>
              <Badge variant="default">{a.status}</Badge>
            </div>
          ))}
        </div>
      </Card>
    </div>
  );
}
