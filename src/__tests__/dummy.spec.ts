import { describe, expect, it } from "vitest";

describe.concurrent("dummy", () => {
  it("will pass", async () => {
    expect(true).to.be.true;
  });
  it("will also pass", async () => {
    expect(1).to.equal(1);
  });
});
