import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { BrowserRouter, Route, Routes } from "react-router-dom";
import { Toaster as Sonner } from "@/components/ui/sonner";
import { Toaster } from "@/components/ui/toaster";
import { TooltipProvider } from "@/components/ui/tooltip";
import LandingPage from "./pages/LandingPage";
import Login from "./pages/Login";
import Dashboard from "./pages/Dashboard";
import NotFound from "./pages/NotFound";
import ModulePage from "./pages/ModulePage";
import {
  Users, UserPlus, Landmark, Building2, Briefcase,
  DollarSign, CreditCard, HeartPulse, Handshake,
  BarChart3, Globe, UserCircle, Settings,
} from "lucide-react";

const queryClient = new QueryClient();

const modules = [
  { path: "/associados", title: "Associados", desc: "Gerencie o cadastro de associados do sindicato.", icon: Users },
  { path: "/dependentes", title: "Dependentes", desc: "Controle os dependentes vinculados aos associados.", icon: UserPlus },
  { path: "/bancos", title: "Bancos", desc: "Cadastro e gestão de bancos.", icon: Landmark },
  { path: "/agencias", title: "Agências", desc: "Cadastro e gestão de agências bancárias.", icon: Building2 },
  { path: "/historico", title: "Histórico Profissional", desc: "Trajetória profissional dos associados.", icon: Briefcase },
  { path: "/mensalidades", title: "Mensalidades", desc: "Controle de mensalidades e cobranças.", icon: DollarSign },
  { path: "/pagamentos", title: "Pagamentos", desc: "Registro e acompanhamento de pagamentos.", icon: CreditCard },
  { path: "/servicos", title: "Serviços", desc: "Serviços internos e externos disponíveis.", icon: HeartPulse },
  { path: "/convenios", title: "Convênios", desc: "Parceiros e convênios do sindicato.", icon: Handshake },
  { path: "/relatorios", title: "Relatórios", desc: "Relatórios financeiros e operacionais.", icon: BarChart3 },
  { path: "/cms", title: "CMS", desc: "Gerencie o conteúdo do site institucional.", icon: Globe },
  { path: "/portal", title: "Portal do Associado", desc: "Área restrita para os associados.", icon: UserCircle },
  { path: "/configuracoes", title: "Configurações", desc: "Parâmetros e configurações do sindicato.", icon: Settings },
];

const App = () => (
  <QueryClientProvider client={queryClient}>
    <TooltipProvider>
      <Toaster />
      <Sonner />
      <BrowserRouter>
        <Routes>
          <Route path="/" element={<LandingPage />} />
          <Route path="/login" element={<Login />} />
          <Route path="/dashboard" element={<Dashboard />} />
          {modules.map((m) => (
            <Route
              key={m.path}
              path={m.path}
              element={
                <ModulePage
                  title={m.title}
                  description={m.desc}
                  icon={<m.icon className="h-6 w-6" />}
                />
              }
            />
          ))}
          <Route path="*" element={<NotFound />} />
        </Routes>
      </BrowserRouter>
    </TooltipProvider>
  </QueryClientProvider>
);

export default App;
