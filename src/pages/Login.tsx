import { useState } from "react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Landmark } from "lucide-react";
import { useNavigate } from "react-router-dom";
import { type UserRole, userProfiles } from "@/data/seeders";

export default function Login() {
  const navigate = useNavigate();
  const [selectedRole, setSelectedRole] = useState<UserRole>("gestor");

  const handleLogin = (e: React.FormEvent) => {
    e.preventDefault();
    // Store role in sessionStorage for demo
    sessionStorage.setItem("demo_role", selectedRole);
    navigate("/dashboard");
  };

  return (
    <div className="min-h-screen flex items-center justify-center bg-muted/30 px-4">
      <div className="w-full max-w-md">
        {/* Logo */}
        <div className="flex flex-col items-center mb-8">
          <div className="flex h-12 w-12 items-center justify-center rounded-xl bg-primary mb-4">
            <Landmark className="h-6 w-6 text-primary-foreground" />
          </div>
          <h1 className="text-2xl font-bold text-foreground">Seebam</h1>
          <p className="text-sm text-muted-foreground mt-1">Plataforma de Gestão Sindical</p>
        </div>

        <Card>
          <CardHeader className="text-center">
            <CardTitle className="text-xl">Entrar na plataforma</CardTitle>
            <CardDescription>Selecione um perfil de demonstração para acessar</CardDescription>
          </CardHeader>
          <CardContent>
            <form onSubmit={handleLogin} className="space-y-4">
              <div className="space-y-2">
                <Label htmlFor="role">Perfil de acesso</Label>
                <Select value={selectedRole} onValueChange={(v) => setSelectedRole(v as UserRole)}>
                  <SelectTrigger>
                    <SelectValue />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="super_admin">🔑 Super Admin — Ricardo Mendes</SelectItem>
                    <SelectItem value="gestor">👔 Gestor — Fernanda Oliveira</SelectItem>
                    <SelectItem value="financeiro">💰 Financeiro — Paulo Nascimento</SelectItem>
                    <SelectItem value="atendimento">🎧 Atendimento — Carla Ribeiro</SelectItem>
                    <SelectItem value="associado">👤 Associado — José Almeida</SelectItem>
                  </SelectContent>
                </Select>
              </div>

              <div className="space-y-2">
                <Label htmlFor="email">E-mail</Label>
                <Input
                  id="email"
                  type="email"
                  value={userProfiles[selectedRole].email}
                  readOnly
                  className="bg-muted"
                />
              </div>

              <div className="space-y-2">
                <Label htmlFor="password">Senha</Label>
                <Input id="password" type="password" value="••••••••" readOnly className="bg-muted" />
              </div>

              <Button type="submit" className="w-full" size="lg">
                Entrar como {userProfiles[selectedRole].roleLabel}
              </Button>
            </form>
          </CardContent>
        </Card>

        <p className="text-center text-xs text-muted-foreground mt-6">
          Ambiente de demonstração — selecione um perfil para explorar o sistema.
        </p>
      </div>
    </div>
  );
}
