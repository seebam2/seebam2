import { Button } from "@/components/ui/button";
import { Card } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { useNavigate } from "react-router-dom";
import {
  Users, Shield, BarChart3, HeartPulse, Globe, Landmark,
  ChevronRight, CheckCircle2, ArrowRight, Zap, Lock, Smartphone,
} from "lucide-react";

const features = [
  { icon: Users, title: "Gestão de Associados", desc: "Cadastro completo, dependentes, histórico profissional e controle de status." },
  { icon: HeartPulse, title: "Motor de Benefícios", desc: "Regras de elegibilidade, cálculo automático de valores e descontos por tipo." },
  { icon: BarChart3, title: "Financeiro Integrado", desc: "Mensalidades, pagamentos, inadimplência e relatórios em tempo real." },
  { icon: Globe, title: "CMS Institucional", desc: "Site integrado com notícias, eventos, documentos e editor visual." },
  { icon: Shield, title: "Multi-Tenant SaaS", desc: "Cada sindicato com base isolada, configurações e regras próprias." },
  { icon: Landmark, title: "Portal do Associado", desc: "Área exclusiva com dados pessoais, pagamentos e agendamento de serviços." },
];

const plans = [
  {
    name: "Básico",
    price: "R$ 890",
    period: "/mês",
    desc: "Para sindicatos de pequeno porte",
    features: ["Até 500 associados", "3 usuários administrativos", "Módulos essenciais", "Suporte por e-mail"],
    highlight: false,
  },
  {
    name: "Profissional",
    price: "R$ 1.890",
    period: "/mês",
    desc: "Para sindicatos em crescimento",
    features: ["Até 3.000 associados", "10 usuários administrativos", "Todos os módulos", "CMS integrado", "Suporte prioritário"],
    highlight: true,
  },
  {
    name: "Enterprise",
    price: "Sob consulta",
    period: "",
    desc: "Para grandes sindicatos",
    features: ["Associados ilimitados", "Usuários ilimitados", "API personalizada", "SLA dedicado", "Onboarding assistido"],
    highlight: false,
  },
];

const stats = [
  { value: "14+", label: "Sindicatos ativos" },
  { value: "18.000+", label: "Associados gerenciados" },
  { value: "99,97%", label: "Uptime da plataforma" },
  { value: "R$ 2M+", label: "Processados por mês" },
];

export default function LandingPage() {
  const navigate = useNavigate();

  return (
    <div className="min-h-screen bg-background">
      {/* Navbar */}
      <header className="sticky top-0 z-50 border-b bg-background/80 backdrop-blur-md">
        <div className="max-w-7xl mx-auto flex items-center justify-between px-6 h-16">
          <div className="flex items-center gap-3">
            <div className="flex h-9 w-9 items-center justify-center rounded-lg bg-primary">
              <Landmark className="h-5 w-5 text-primary-foreground" />
            </div>
            <span className="text-lg font-bold text-foreground">Seebam</span>
          </div>
          <nav className="hidden md:flex items-center gap-8">
            <a href="#funcionalidades" className="text-sm text-muted-foreground hover:text-foreground transition-colors">Funcionalidades</a>
            <a href="#planos" className="text-sm text-muted-foreground hover:text-foreground transition-colors">Planos</a>
            <a href="#numeros" className="text-sm text-muted-foreground hover:text-foreground transition-colors">Números</a>
          </nav>
          <div className="flex items-center gap-3">
            <Button variant="ghost" onClick={() => navigate("/login")}>Entrar</Button>
            <Button onClick={() => navigate("/login")}>
              Começar agora <ArrowRight className="h-4 w-4" />
            </Button>
          </div>
        </div>
      </header>

      {/* Hero */}
      <section className="relative overflow-hidden">
        <div className="absolute inset-0 bg-gradient-to-b from-primary/5 to-transparent pointer-events-none" />
        <div className="max-w-7xl mx-auto px-6 pt-20 pb-24 text-center relative">
          <Badge variant="secondary" className="mb-6 px-4 py-1.5">
            <Zap className="h-3 w-3 mr-1.5" /> Plataforma SaaS para Sindicatos
          </Badge>
          <h1 className="text-4xl md:text-6xl font-bold text-foreground max-w-4xl mx-auto leading-tight tracking-tight">
            Gestão sindical <span className="text-primary">moderna e completa</span> em uma única plataforma
          </h1>
          <p className="mt-6 text-lg text-muted-foreground max-w-2xl mx-auto">
            Controle associados, finanças, serviços, convênios e muito mais. 
            Automatize processos e foque no que importa: seus associados.
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center mt-10">
            <Button size="lg" onClick={() => navigate("/login")} className="text-base px-8">
              Começar gratuitamente <ChevronRight className="h-4 w-4" />
            </Button>
            <Button size="lg" variant="outline" className="text-base px-8">
              Agendar demonstração
            </Button>
          </div>
          <div className="mt-8 flex items-center justify-center gap-6 text-sm text-muted-foreground">
            <span className="flex items-center gap-1.5"><CheckCircle2 className="h-4 w-4 text-primary" /> 14 dias grátis</span>
            <span className="flex items-center gap-1.5"><Lock className="h-4 w-4 text-primary" /> Dados seguros</span>
            <span className="flex items-center gap-1.5"><Smartphone className="h-4 w-4 text-primary" /> 100% responsivo</span>
          </div>
        </div>
      </section>

      {/* Stats */}
      <section id="numeros" className="border-y bg-muted/30">
        <div className="max-w-7xl mx-auto px-6 py-16">
          <div className="grid grid-cols-2 md:grid-cols-4 gap-8">
            {stats.map((s) => (
              <div key={s.label} className="text-center">
                <p className="text-3xl md:text-4xl font-bold text-primary">{s.value}</p>
                <p className="mt-1 text-sm text-muted-foreground">{s.label}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Features */}
      <section id="funcionalidades" className="max-w-7xl mx-auto px-6 py-24">
        <div className="text-center mb-16">
          <Badge variant="outline" className="mb-4">Funcionalidades</Badge>
          <h2 className="text-3xl md:text-4xl font-bold text-foreground">Tudo que seu sindicato precisa</h2>
          <p className="mt-4 text-muted-foreground max-w-xl mx-auto">
            Módulos integrados que cobrem todas as necessidades operacionais e administrativas.
          </p>
        </div>
        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
          {features.map((f) => (
            <Card key={f.title} className="p-6 hover:shadow-md transition-shadow border">
              <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 mb-4">
                <f.icon className="h-5 w-5 text-primary" />
              </div>
              <h3 className="text-base font-semibold text-card-foreground">{f.title}</h3>
              <p className="mt-2 text-sm text-muted-foreground leading-relaxed">{f.desc}</p>
            </Card>
          ))}
        </div>
      </section>

      {/* Pricing */}
      <section id="planos" className="bg-muted/30 border-y">
        <div className="max-w-7xl mx-auto px-6 py-24">
          <div className="text-center mb-16">
            <Badge variant="outline" className="mb-4">Planos</Badge>
            <h2 className="text-3xl md:text-4xl font-bold text-foreground">Escolha o plano ideal</h2>
            <p className="mt-4 text-muted-foreground">Preços justos que crescem com seu sindicato.</p>
          </div>
          <div className="grid md:grid-cols-3 gap-6 max-w-5xl mx-auto">
            {plans.map((plan) => (
              <Card
                key={plan.name}
                className={`p-8 flex flex-col ${plan.highlight ? "border-primary shadow-lg ring-1 ring-primary/20 relative" : ""}`}
              >
                {plan.highlight && (
                  <Badge className="absolute -top-3 left-1/2 -translate-x-1/2 px-4">Mais popular</Badge>
                )}
                <h3 className="text-lg font-semibold text-card-foreground">{plan.name}</h3>
                <p className="text-sm text-muted-foreground mt-1">{plan.desc}</p>
                <div className="mt-6 mb-6">
                  <span className="text-3xl font-bold text-foreground">{plan.price}</span>
                  <span className="text-muted-foreground">{plan.period}</span>
                </div>
                <ul className="space-y-3 flex-1">
                  {plan.features.map((feat) => (
                    <li key={feat} className="flex items-start gap-2 text-sm text-muted-foreground">
                      <CheckCircle2 className="h-4 w-4 text-primary shrink-0 mt-0.5" />
                      {feat}
                    </li>
                  ))}
                </ul>
                <Button
                  className="mt-8 w-full"
                  variant={plan.highlight ? "default" : "outline"}
                  onClick={() => navigate("/login")}
                >
                  {plan.price === "Sob consulta" ? "Falar com vendas" : "Começar agora"}
                </Button>
              </Card>
            ))}
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="max-w-7xl mx-auto px-6 py-24 text-center">
        <h2 className="text-3xl md:text-4xl font-bold text-foreground">
          Pronto para modernizar seu sindicato?
        </h2>
        <p className="mt-4 text-muted-foreground max-w-xl mx-auto">
          Comece agora com 14 dias gratuitos. Sem compromisso, sem cartão de crédito.
        </p>
        <Button size="lg" className="mt-8 text-base px-10" onClick={() => navigate("/login")}>
          Criar conta gratuita <ArrowRight className="h-4 w-4" />
        </Button>
      </section>

      {/* Footer */}
      <footer className="border-t bg-muted/30">
        <div className="max-w-7xl mx-auto px-6 py-10 flex flex-col md:flex-row items-center justify-between gap-4">
          <div className="flex items-center gap-2">
            <Landmark className="h-5 w-5 text-primary" />
            <span className="font-semibold text-foreground">Seebam</span>
          </div>
          <p className="text-sm text-muted-foreground">© 2026 Seebam. Todos os direitos reservados.</p>
        </div>
      </footer>
    </div>
  );
}
